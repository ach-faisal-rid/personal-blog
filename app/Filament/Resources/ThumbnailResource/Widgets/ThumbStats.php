<?php

namespace App\Filament\Resources\ThumbnailResource\Widgets;

use App\Models\Thumbnail;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ThumbStats extends BaseWidget
{
    protected ?string $heading = 'Thumb Statistics';

    protected function getStats(): array
    {
        $totalThumbnails = Thumbnail::count();
        $activeThumbnails = Thumbnail::where('status', '1')->count();
        $inactiveThumbnails = Thumbnail::where('status', '0')->count();

        return [
            Stat::make('Total Thumbnails', $totalThumbnails)
                ->description('Total uploaded thumbnails')
                ->descriptionIcon('heroicon-o-photo')
                ->icon('heroicon-o-rectangle-stack')
                ->chart([$totalThumbnails - 5, $totalThumbnails - 3, $totalThumbnails, $totalThumbnails + 2])
                ->color('info'),


            Stat::make('Active Thumbnails', $activeThumbnails)
                ->description('Currently active thumbnails')
                ->descriptionIcon('heroicon-o-check-circle')
                ->icon('heroicon-o-check-badge')
                ->chart([$activeThumbnails - 2, $activeThumbnails, $activeThumbnails + 3])
                ->color('success'),

            Stat::make('InActive Thumbnails', $inactiveThumbnails)
                ->description('Currently active thumbnails')
                ->descriptionIcon('heroicon-o-check-circle')
                ->icon('heroicon-o-x-circle')
                ->chart([$inactiveThumbnails, $inactiveThumbnails + 1, $inactiveThumbnails + 2])
                ->color('danger'),
        ];
    }
}
