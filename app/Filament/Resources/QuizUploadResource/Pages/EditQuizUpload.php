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
}
