<?php

namespace App\Filament\Resources\RoleResource\Widgets;

use App\Models\Role;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RoleStats extends BaseWidget
{
    protected ?string $heading = 'Role Statistics';

    protected function getStats(): array
    {
        $roleCount = Role::count();

        return [
            Stat::make('Total Roles', $roleCount)
                ->descriptionIcon('heroicon-o-shield-check', IconPosition::Before)
                ->description('Total roles registered in the system')
                ->color($roleCount > 10 ? 'success' : 'warning') // Beri warna berbeda berdasarkan jumlah role
                ->chart([3, 5, 8, 10, $roleCount]) // Tambahkan grafik tren kecil
                ->icon('heroicon-o-users') // Tambahkan ikon utama
                ->extraAttributes([
                    'class' => 'shadow-lg rounded-lg transition-all duration-300 hover:scale-105',
                ]),
        ];
    }
}
