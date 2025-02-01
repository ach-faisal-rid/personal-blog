<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $navigationIcon = 'heroicon-s-arrow-up-on-square-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->required(),

                Textarea::make('description')
                    ->label('Description')
                    ->required(),

                TextInput::make('youtube_url')
                    ->label('YouTube URL')
                    ->url()
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

                TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable()
                    ->limit(30),

                    // untuk menambahkan kolom gambar
                    // TextColumn::make('thumbnails.url')
                    //     ->label('Thumbnail URL')
                    //     ->sortable()
                    //     ->searchable()
                    //     ->getStateUsing(fn 
                    //     ($record) => 
                    //     $record->thumbnails->pluck('url')->join(', '))
                    //     ->badge(),

                ImageColumn::make('thumbnail_url')
                    ->label('Thumbnail')
                    ->getStateUsing(fn 
                        ($record) => 
                        $record->thumbnails->pluck('url')->first() ?? null)
                    ->size(100)
                    ->square(),

                TextColumn::make('categories.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable()
                    ->badge(),

                TextColumn::make('authors.name')
                    ->label('Author')
                    ->sortable()
                    ->searchable()
                    ->badge(),
                    
                TextColumn::make('youtube_url')
                    ->label('YouTube Link')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        $url = $record->youtube_url;
                        $shortenedUrl = substr($url, 0, 30); // Ambil 30 karakter pertama dari URL
                        $icon = '';
                
                        // Cek platform sosial media dan pilih ikon yang sesuai
                        if (preg_match('/youtube\.com|youtu\.be/', $url)) {
                            $icon = '<x-heroicon-o-video-camera class="w-5 h-5 text-red-600" />';
                        } elseif (preg_match('/tiktok\.com/', $url)) {
                            $icon = '<x-heroicon-o-play class="w-5 h-5 text-black" />';
                        } elseif (preg_match('/instagram\.com/', $url)) {
                            $icon = '<x-heroicon-o-camera class="w-5 h-5 text-pink-600" />';
                        }
                
                        // Menampilkan ikon dan URL yang dipersingkat
                        if ($icon) {
                            return "<a href='{$url}' target='_blank'>{$icon} {$shortenedUrl}...</a>";
                        }
                
                        // Jika tidak ada ikon, hanya menampilkan URL yang dipersingkat
                        return "<a href='{$url}' target='_blank'>{$shortenedUrl}...</a>";
                    })
                    ->html(),
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
