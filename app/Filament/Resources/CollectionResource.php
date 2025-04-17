<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollectionResource\Pages;
use App\Filament\Resources\CollectionResource\RelationManagers;
use Modules\Bookmarking\Entities\Collection;
use Modules\Bookmarking\Entities\Bookmark;
use App\Models\RoleUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Bookmark Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('role_user_id')
                    ->label('Author')
                    ->relationship('roleUser', 'name')
                    ->preload()
                    ->searchable()
                    ->options(fn () => RoleUser::with('user')
                        ->get()
                        ->mapWithKeys(fn ($roleUser) => [$roleUser->id => $roleUser->user->name])
                        ->toArray()),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Koleksi')
                    ->required(),
                Forms\Components\Select::make('bookmarks')
                    ->label('Bookmarks')
                    ->relationship('bookmarks', 'title')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ID Column
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->icon('heroicon-o-hashtag')
                    ->color('gray')
                    ->sortable()
                    ->searchable()
                    ->alignLeft()
                    ->width('70px'),

                // Title Column
                Tables\Columns\TextColumn::make('name')
                    ->label('Koleksi')
                    ->searchable()
                    ->limit(20)
                    ->tooltip(fn($record) => $record->name)
                    ->wrap(),

                // author column
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Ditambahkan')
                    ->sortable()
                    ->searchable()
                    ->color('info'),

                // bookmarks count column 
                Tables\Columns\TextColumn::make('bookmarks_count')
                    ->label('Jumlah Bookmark')
                    ->getStateUsing(fn ($record) => $record->bookmarks()->count())
                    ->sortable(),

                // created_at
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Buat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->color('gray'),
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
            'index' => Pages\ListCollections::route('/'),
            'create' => Pages\CreateCollection::route('/create'),
            'edit' => Pages\EditCollection::route('/{record}/edit'),
        ];
    }
}