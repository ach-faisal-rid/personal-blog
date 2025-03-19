<?php

namespace App\Filament\Resources\ThumbnailResource\Pages;

use App\Filament\Resources\ThumbnailResource;
use App\Filament\Resources\ThumbnailResource\Widgets\ThumbStats;
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

    protected function getHeaderWidgets(): array
    {
        return [
                ThumbStats::class,
        ];
    }
}
