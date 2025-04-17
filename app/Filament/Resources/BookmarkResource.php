<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookmarkResource\Pages;
use App\Filament\Resources\BookmarkResource\RelationManagers;
use Modules\Bookmarking\Entities\Bookmark;

use App\Models\RoleUser;
use Modules\Bookmarking\Helpers\BookmarkHelper;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookmarkResource extends Resource
{
    protected static ?string $model = Bookmark::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';
    protected static ?string $navigationGroup = 'Bookmark Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->required()
                    ->reactive() // ini penting agar perubahan bisa direspons
                    ->debounce(500) // delay sedikit agar tidak terlalu cepat
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (filter_var($state, FILTER_VALIDATE_URL)) {
                            $title = BookmarkHelper::fetchTitle($state);
                            if ($title) {
                                $set('title', $title);
                            }
                        }
                    }),

                Forms\Components\TextInput::make('title')
                    ->label('Judul Halaman')
                    ->required()
                    ->placeholder('Akan otomatis terisi dari URL...'),
                Forms\Components\Textarea::make('description')->nullable(),
                Forms\Components\Select::make('collections')
                    ->label('Collections')
                    ->relationship('collections', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                Forms\Components\Select::make('role_user_id')
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(20)
                    ->tooltip(fn($record) => $record->title)
                    ->wrap(),

                // URL Column
                Tables\Columns\TextColumn::make('url')
                    ->label('Tautan')
                    ->limit(30)
                    ->tooltip(fn($record) => $record->url),

                // User Column
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Ditambahkan')
                    ->sortable()
                    ->searchable()
                    ->color('info'),

                // collections count column 
                Tables\Columns\TextColumn::make('collections_count')
                    ->label('Jumlah Collection')
                    ->getStateUsing(fn ($record) => $record->collections()->count())
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
            'index' => Pages\ListBookmarks::route('/'),
            'create' => Pages\CreateBookmark::route('/create'),
            'edit' => Pages\EditBookmark::route('/{record}/edit'),
        ];
    }
}
