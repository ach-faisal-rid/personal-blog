<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\Layout\Split;
use Modules\ContentManagement\Entities\Thumbnail;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\ThumbnailResource\Pages;
use Illuminate\Support\Facades\Storage;

class ThumbnailResource extends Resource
{
    protected static ?string $model = Thumbnail::class;
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('thumbnail_type')
                            ->label('Choose Thumbnail Method')
                            ->options([
                                'upload' => 'Upload Image',
                                'url' => 'Use URL',
                            ])
                            ->default(fn($record) => $record?->thumbnail_type)
                            ->reactive()
                            ->helperText('Pilih cara memasukkan thumbnail, upload atau pakai URL.')
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $set('image', null);
                                $set('url', null);
                            }),

                        FileUpload::make('image')
                            ->label('Upload Image')
                            ->image()
                            ->directory('thumbnails')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->hidden(fn(Forms\Get $get) => $get('thumbnail_type') !== 'upload')
                            ->required(fn(Forms\Get $get) => $get('thumbnail_type') === 'upload')
                            ->deletable(false)
                            ->preserveFilenames()
                            ->columnSpanFull()
                            ->helperText('Format jpg, png maksimal 2MB.')
                            ->default(fn($record) => $record?->image),

                        TextInput::make('url')
                            ->label('Thumbnail URL')
                            ->url()
                            ->maxLength(255)
                            ->hidden(fn(Forms\Get $get) => $get('thumbnail_type') !== 'url')
                            ->required(fn(Forms\Get $get) => $get('thumbnail_type') === 'url')
                            ->default(fn($record) => $record?->url)
                            ->placeholder('https://example.com/image.jpg')
                            ->columnSpanFull()
                            ->helperText('Masukkan URL lengkap gambar thumbnail.'),

                        Toggle::make('status')
                            ->label('Status')
                            ->default(true)
                            ->onIcon('heroicon-s-check-circle')
                            ->offIcon('heroicon-s-x-mark')
                            ->onColor('success')
                            ->offColor('danger')
                            ->helperText('Aktifkan jika thumbnail ini aktif untuk digunakan.'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    TextColumn::make('id')
                        ->label('ID')
                        ->sortable()
                        ->searchable()
                        ->icon('heroicon-o-hashtag')
                        ->color('gray')
                        ->width(65),
                        
                    ImageColumn::make('image_url')
                        ->label('Preview')
                        ->height(60)
                        ->width(60)
                        ->grow(false),

                    TextColumn::make('thumbnail_type')
                        ->label('Type')
                        ->badge()
                        ->formatStateUsing(fn($record) => $record->thumbnail_type)
                        ->color(fn(string $state): string => match ($state) {
                            'upload' => 'success',
                            'url' => 'info',
                            default => 'gray',
                        }),

                    TextColumn::make('created_at')
                        ->label('Uploaded')
                        ->dateTime()
                        ->sortable(),

                    ToggleColumn::make('status')
                        ->label('Active')
                        ->onColor('success')
                        ->offColor('danger'),
                ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('thumbnail_type')
                    ->options([
                        'upload' => 'Uploaded Image',
                        'url' => 'External URL',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data, Thumbnail $record): array {
                        if ($data['thumbnail_type'] === 'url' && $record->image) {
                            Storage::delete($record->image);
                            $data['image'] = null;
                        } elseif ($data['thumbnail_type'] === 'upload' && $record->url) {
                            $data['url'] = null;
                        }
                        return $data;
                    }),

                Tables\Actions\DeleteAction::make()
                    ->before(function (Thumbnail $record) {
                        if ($record->image) {
                            Storage::delete($record->image);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            $records->each(function ($record) {
                                if ($record->image) {
                                    Storage::delete($record->image);
                                }
                            });
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListThumbnails::route('/'),
            'create' => Pages\CreateThumbnail::route('/create'),
            'edit' => Pages\EditThumbnail::route('/{record}/edit'),
        ];
    }
}
