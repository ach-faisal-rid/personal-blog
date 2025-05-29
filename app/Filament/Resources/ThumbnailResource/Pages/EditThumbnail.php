<?php

namespace App\Filament\Resources\ThumbnailResource\Pages;

use App\Filament\Resources\ThumbnailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditThumbnail extends EditRecord
{
    protected static string $resource = ThumbnailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}