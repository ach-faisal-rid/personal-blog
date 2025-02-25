<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Carbon\Carbon;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class UserStats extends BaseWidget {
    protected function getCards(): array
    {
        $totalUsers = User::count();
        $usersToday = User::whereDate('created_at', Carbon::today())->count();
        $usersThisMonth = User::whereMonth('created_at', Carbon::now()->month)->count();
        $usersThisYear = User::whereYear('created_at', Carbon::now()->year)->count();

        return [
            Card::make('Total Users', $totalUsers)
                ->description('Total Registered Users')
                ->icon('heroicon-o-user-group')
                ->descriptionIcon('heroicon-o-information-circle', IconPosition::Before)
                ->color('primary'),

            Card::make('Users Today', $usersToday)
                ->description('New users today')
                ->icon('heroicon-o-calendar')
                ->color('success')
                ->chart([rand(1, 5), rand(5, 10), rand(10, 20), $usersToday]),

            Card::make('Users This Month', $usersThisMonth)
                ->description('New users this month')
                ->icon('heroicon-o-moon')
                ->color('warning')
                ->chart([rand(10, 50), rand(50, 100), $usersThisMonth]),

            Card::make('Users This Year', $usersThisYear)
                ->description('New users this year')
                ->icon('heroicon-o-calendar-days')
                ->color('info')
                ->chart([rand(100, 300), rand(300, 500), $usersThisYear]),
        ];
    }
}