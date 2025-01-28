<?php

namespace App\Filament\Resources\PostThumbnailResource\Pages;

use App\Filament\Resources\PostThumbnailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostThumbnail extends EditRecord
{
    protected static string $resource = PostThumbnailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
