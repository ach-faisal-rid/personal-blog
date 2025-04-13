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

                Section::make('Summary')
                    ->schema([
                        TextEntry::make('question_count')
                            ->label('Total Soal')
                            ->default(fn ($record) => $record->questions->count()),
                        TextEntry::make('options_count')
                            ->label('Total Pilihan Jawaban')
                            ->default(fn ($record) => $record->questions->sum(fn ($question) => $question->options->count())),
                    ]),

                Section::make('List Soal')
                    ->schema([
                        RepeatableEntry::make('questions')
                            ->label('Daftar Soal')
                            ->columns(1)
                            ->schema([
                                ImageEntry::make('image')
                                    ->url(fn ($record) => $record->image ? asset('temp_extract/' . $record->image) : null),
                                TextEntry::make('question')->label('Pertanyaan'),
                                RepeatableEntry::make('options')
                                    ->label('Pilihan Jawaban')
                                    ->columns(1)
                                    ->schema([
                                        TextEntry::make('option_text')->label('Pilihan'),
                                        TextEntry::make('is_correct')
                                            ->label('Jawaban ?')
                                            ->formatStateUsing(fn (bool $state) => $state ? '✅' : '❌'),
                                        TextEntry::make('explanation')
                                            ->label('Penjelasan: ')
                                            ->formatStateUsing(fn (bool $state) => $state ? '✅' : '❌'),
                                    ])
                                    ->default(function ($record, $key, $index) {
                                        if (!isset($record['options'][$index])) {
                                            return null;
                                        }
                                        $option = $record['options'][$index];
                                        return [
                                            'option_text' => $option['option_text'],
                                            'is_correct' => $option['is_correct'],
                                            'explanation' => $option['is_correct'] ? $option['explanation'] : null,
                                        ];
                                    }),
                            ])
                            ->default(function ($record) {
                                return $record;
                            }),
                    ]),
            ]);
    }
}