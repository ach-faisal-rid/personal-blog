<?php

namespace App\Filament\Resources\PostResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostChart extends ChartWidget
{
    protected static ?string $heading = 'Post Statistics 📊';
    protected static ?string $pollingInterval = '10s'; // Auto refresh setiap 10 detik

    protected function getData(): array
    {
        $posts = Post::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Posts per Month',
                    'data' => $posts->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                ],
            ],
            'labels' => $posts->pluck('month')->map(fn ($m) => date('F', mktime(0, 0, 0, $m, 1)))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Bisa diganti: line, pie, bar, doughnut, radar
    }
}