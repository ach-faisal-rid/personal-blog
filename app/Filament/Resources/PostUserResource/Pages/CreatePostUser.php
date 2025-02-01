<?php

namespace App\Filament\Resources\PostUserResource\Pages;

use App\Filament\Resources\PostUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePostUser extends CreateRecord
{
    protected static string $resource = PostUserResource::class;
}
