<?php

namespace App\Filament\Resources\QuizUploadResource\Pages;

use App\Filament\Resources\QuizUploadResource;
use App\Models\Question;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\ImageEntry;

class ViewQuizUpload extends ViewRecord
{
    protected static string $resource = QuizUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Quiz Info')
                    ->schema([
                        TextEntry::make('id'),
                        TextEntry::make('title'),
                        TextEntry::make('created_at')->dateTime(),
                    ]),

                Section::make('List Soal')
                    ->schema([
                        RepeatableEntry::make('questions')
                            ->label('Daftar Soal')
                            ->schema([
                                TextEntry::make('question')->label('Pertanyaan'),
                                // ImageEntry::make('image')->label('Gambar Soal'),

                                RepeatableEntry::make('options')
                                    ->label('Pilihan Jawaban')
                                    ->schema([
                                        TextEntry::make('option_text')->label('Pilihan'),
                                        TextEntry::make('is_correct')
                                            ->label('Benar?')
                                            ->formatStateUsing(fn(bool $state) => $state ? '✅' : '❌'),
                                    ]),
                            ])
                            ->columns(1), // kamu bisa atur layout-nya di sini
                    ]),
            ]);
    }
}
