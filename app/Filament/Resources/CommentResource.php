<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Builder;
use Modules\ContentManagement\Entities\Comment;
use App\Filament\Resources\CommentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CommentResource\RelationManagers;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('comment')
                    ->label('Comment Text')
                    ->placeholder('Enter your comment...')
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
                        ->searchable()
                        ->icon('heroicon-o-hashtag')
                        ->color('gray')
                        ->width(65),
                        
                TextColumn::make('comment')
                    ->label('Comment Text')
                    ->limit(50),
                    
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('recent')
                    ->label('Recent Comments')
                    ->query(fn ($query) => $query->where('created_at', '>=', now()->subDays(7))),
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
