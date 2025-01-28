<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThumbnailResource\Pages;
use App\Filament\Resources\ThumbnailResource\RelationManagers;
use App\Models\Thumbnail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
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
                Forms\Components\TextInput::make('url')
                    ->label('Thumbnail URL')
                    ->required()
                    ->url() // Validasi sebagai URL
                    ->placeholder('https://example.com/image.jpg')
                    ->maxLength(255), // Batasi panjang URL
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('url')
                    ->label('Thumbnail URL')
                    ->url(fn($record) => $record->url, true) // Jadikan URL sebagai tautan
                    ->searchable() // Aktifkan pencarian
                    ->sortable()
                    ->badge(), // Aktifkan pengurutan
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
