<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostThumbnailResource\Pages;
use App\Filament\Resources\PostThumbnailResource\RelationManagers;
use App\Models\Post;
use App\Models\PostThumbnail;
use App\Models\Thumbnail;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostThumbnailResource extends Resource
{
    protected static ?string $model = PostThumbnail::class;
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('post_id')
                    ->label('Post')
                    ->options(
                        Post::all()->pluck('title', 'id')->filter(function ($value) {
                            return $value !== null; // Pastikan hanya nilai non-null yang diambil
                        })->toArray()
                    )
                    ->required(),

                Select::make('thumbnail_id')
                    ->label('Thumbnail')
                    ->options(
                        Thumbnail::all()->pluck('url', 'id')->filter(function ($value) {
                            return $value !== null; // Pastikan hanya nilai non-null yang diambil
                        })->toArray()
                    )
                    ->required(),
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

                TextColumn::make('post.title')
                    ->label('Post')
                    ->sortable()
                    ->searchable()
                    ->badge(),

                TextColumn::make('thumbnail.url')
                    ->label('Thumbnail')
                    ->sortable()
                    ->searchable()
                    ->badge(),
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
            'index' => Pages\ListPostThumbnails::route('/'),
            'create' => Pages\CreatePostThumbnail::route('/create'),
            'edit' => Pages\EditPostThumbnail::route('/{record}/edit'),
        ];
    }
}
