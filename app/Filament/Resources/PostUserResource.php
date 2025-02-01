<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostUserResource\Pages;
use App\Filament\Resources\PostUserResource\RelationManagers;
use App\Models\Post;
use App\Models\PostUser;
use App\Models\RoleUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostUserResource extends Resource
{
    protected static ?string $model = PostUser::class;
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('post_id')
                    ->label('Post')
                    ->options(fn () => Post::pluck('title', 'id')->toArray())
                    ->required(),

                Select::make('role_user_id')
                    ->label('Author')
                    ->options(fn () => RoleUser::with('user')
                    ->get()
                    ->mapWithKeys(fn ($roleUser) => [$roleUser->id => $roleUser->user->name])
                    ->toArray()),
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
                    ->searchable(),

                TextColumn::make('roleUser.user.name')
                    ->label('Author')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListPostUsers::route('/'),
            'create' => Pages\CreatePostUser::route('/create'),
            'edit' => Pages\EditPostUser::route('/{record}/edit'),
        ];
    }
}
