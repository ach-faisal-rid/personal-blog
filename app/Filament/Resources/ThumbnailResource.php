<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThumbnailResource\Pages;
use App\Filament\Resources\ThumbnailResource\RelationManagers;
use App\Models\Thumbnail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ThumbnailResource extends Resource
{
    protected static ?string $model = Thumbnail::class;
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thumbnail Selection')
                
                ->schema([
                
                Select::make('thumbnail_type')
                    ->label('Choose Thumbnail Method')
                    ->options([
                        'upload' => 'Upload Image',
                        'url' => 'Use URL',
                    ])
                    ->default('upload')
                    ->reactive(),

                FileUpload::make('image')
                    ->label('Upload Image')
                    ->image()
                    ->directory('thumbnails') // Direktori penyimpanan
                    ->maxSize(2048) // Maksimal ukuran 2MB
                    ->hidden(fn (Get $get) => $get('thumbnail_type') !== 'upload'),

                TextInput::make('url')
                    ->label('Thumbnail URL')
                    ->required()
                    ->url() // Validasi sebagai URL
                    ->placeholder('https://example.com/image.jpg')
                    ->maxLength(255)
                    ->hidden(fn (Get $get) => $get('thumbnail_type') !== 'url'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->width(50)
                    ->icon('heroicon-o-hashtag')
                    ->color('gray')
                    ->width(65),

                ImageColumn::make('image_url')
                    ->label('Thumbnail Image')
                    ->height(100)
                    ->width(80)
                    ->sortable()
                    ->searchable()
                    ->extraAttributes([
                        'style' => 'object-fit: cover; border-radius: 2px;'
                    ])
                    ->getStateUsing(fn ($record) => $record->image_url),

                TextColumn::make('thumbnail_type')
                    ->label('Thumbnail Type')
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->thumbnail_type),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
