<?php

namespace App\Filament\Resources\PostResource\Widgets;

use Filament\Widgets\Widget;
use App\Models\Post;

class PostWidget extends Widget
{
    protected static string $view = 'filament.widgets.post-widget';
    public $total;

    public function mount()
    {
        $this->total = Post::count();
    }
}
