<?php

namespace App\Filament\Resources\ThumbnailResource\Pages;

use App\Filament\Resources\ThumbnailResource;
use Filament\Resources\Pages\ViewRecord;

class ViewThumbnail extends ViewRecord
{
    protected static string $resource = ThumbnailResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}