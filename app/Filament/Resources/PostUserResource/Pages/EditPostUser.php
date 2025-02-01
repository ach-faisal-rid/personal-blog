<?php

namespace App\Filament\Resources\PostUserResource\Pages;

use App\Filament\Resources\PostUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostUser extends EditRecord
{
    protected static string $resource = PostUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
