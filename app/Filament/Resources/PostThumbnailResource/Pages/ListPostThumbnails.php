<?php

namespace App\Filament\Resources\PostThumbnailResource\Pages;

use App\Filament\Resources\PostThumbnailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostThumbnails extends ListRecords
{
    protected static string $resource = PostThumbnailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
