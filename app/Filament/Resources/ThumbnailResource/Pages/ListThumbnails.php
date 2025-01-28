<?php

namespace App\Filament\Resources\ThumbnailResource\Pages;

use App\Filament\Resources\ThumbnailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThumbnails extends ListRecords
{
    protected static string $resource = ThumbnailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
