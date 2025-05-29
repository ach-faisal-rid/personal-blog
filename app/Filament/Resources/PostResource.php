<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Modules\ContentManagement\Entities\Post;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Modules\ContentManagement\Entities\Thumbnail;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $navigationIcon = 'heroicon-s-arrow-up-on-square-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Post Information')
                    ->description('Informasi dasar untuk post ini.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->placeholder('Judul artikel...')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->placeholder('slug-otomatis-dari-judul'),

                        Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->rows(4),
                    ])
                    ->columns(2),

                Section::make('Metadata')
                    ->schema([
                        TextInput::make('social_url')
                            ->label('Social URL')
                            ->url()
                            ->required()
                            ->placeholder('https://twitter.com/post'),

                        DateTimePicker::make('published_at')
                            ->label('Publish Date')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Relational Info')
                    ->schema([
                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->required(),

                        Select::make('user_id')
                            ->label('Author')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->required(),

                        Select::make('thumbnail_id')
                            ->label('Thumbnail')
                            ->relationship('thumbnail', 'id')
                            ->searchable()
                            ->required()
                    ])
                    ->columns(3),

                Section::make('Publishing')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required()
                            ->helperText('Pilih status untuk publikasi.'),
                    ]),
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

                ImageColumn::make('thumbnail_url')
                    ->label('Thumbnail')
                    ->getStateUsing(fn($record) => $record->thumbnail->image_url ?? null)
                    ->size(100)
                    ->square(),

                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable()
                    ->limit(30),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable()
                    ->badge(),

                TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable()
                    ->searchable()
                    ->badge(),

                TextColumn::make('social_url')
                    ->label('Social Link')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => Str::limit($state, 30))
                    ->url(fn ($record) => $record->social_url, true, )
                    ->html()
                    ->extraAttributes(['class' => 'w-64']),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
