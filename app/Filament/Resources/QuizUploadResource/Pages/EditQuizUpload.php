<?php

namespace App\Filament\Resources\QuizUploadResource\Pages;

use App\Filament\Resources\QuizUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuizUpload extends EditRecord
{
    protected static string $resource = QuizUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // protected function afterSave(): void {
    //         if ($this->record->file_path) {
    //             app(WordQuizImporter::class)->process(
    //                 $this->record->file_path,
    //                 $this->record->quiz_id
    //             );
    //         }
    //     }
}
