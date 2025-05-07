<?php

namespace App\Filament\Resources;

use App\Models\Thumbnail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\ThumbnailResource\Pages;

class ThumbnailResource extends Resource
{
    protected static ?string $model = Thumbnail::class;
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public bool $is_updating_status = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thumbnail Selection')
                    ->schema([
                        Forms\Components\Select::make('thumbnail_type')
                            ->label('Choose Thumbnail Method')
                            ->options([
                                'upload' => 'Upload Image',
                                'url' => 'Use URL',
                            ])
                            ->default('upload')
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                // Reset fields when type changes
                                $set('image', null);
                                $set('url', null);
                            }),
                            
                        Forms\Components\FileUpload::make('image')
                            ->label('Upload Image')
                            ->image()
                            ->directory('thumbnails')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->hidden(fn (Forms\Get $get) => $get('thumbnail_type') !== 'upload')
                            ->required(fn (Forms\Get $get) => $get('thumbnail_type') === 'upload')
                            ->deletable(false) // Biarkan delete handled oleh sistem
                            ->preserveFilenames(),
                            
                        Forms\Components\TextInput::make('url')
                            ->label('Thumbnail URL')
                            ->url()
                            ->maxLength(255)
                            ->hidden(fn (Forms\Get $get) => $get('thumbnail_type') !== 'url')
                            ->required(fn (Forms\Get $get) => $get('thumbnail_type') === 'url'),
                    ]),
                    
                    Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('status')
                            ->label(fn ($state) => $state 
                                ? 'Active ' . __('heroicon-o-check-circle') 
                                : 'Inactive ' . __('heroicon-o-x-mark'))
                            ->default(true)
                            ->onIcon('heroicon-s-check-circle')
                            ->offIcon('heroicon-s-x-mark')
                            ->onColor('success')
                            ->offColor('danger'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ImageColumn::make('image_url')
                        ->label('Preview')
                        ->height(60)
                        ->width(60)
                        ->grow(false),
                        
                    TextColumn::make('thumbnail_type')
                        ->label('Type')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
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
                        ->offColor('danger')
                ])
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('thumbnail_type')
                    ->options([
                        'upload' => 'Uploaded Image',
                        'url' => 'External URL',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data, Thumbnail $record): array {
                        // Jika beralih dari upload ke URL, hapus file lama
                        if ($data['thumbnail_type'] === 'url' && $record->image) {
                            Storage::disk('public')->delete($record->image);
                            $data['image'] = null;
                        }
                        // Jika beralih dari URL ke upload, reset URL
                        elseif ($data['thumbnail_type'] === 'upload' && $record->url) {
                            $data['url'] = null;
                        }
                        
                        return $data;
                    }),
                    
                Tables\Actions\DeleteAction::make()
                    ->before(function (Thumbnail $record) {
                        // Hapus file terkait saat record dihapus
                        if ($record->image) {
                            Storage::disk('public')->delete($record->image);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            // Hapus semua file terkait
                            $records->each(function ($record) {
                                if ($record->image) {
                                    Storage::disk('public')->delete($record->image);
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
            'view' => Pages\ViewThumbnail::route('/{record}'),
            'edit' => Pages\EditThumbnail::route('/{record}/edit'),
        ];
    }
}