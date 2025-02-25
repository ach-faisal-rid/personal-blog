<?php

namespace App\Filament\Resources\RoleResource\Widgets;

use App\Models\Role;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RoleStats extends BaseWidget
{
    // Menentukan heading widget jika diperlukan, tanpa static
    protected ?string $heading = 'Role Statistics';

    /**
     * Mendapatkan statistik yang akan ditampilkan di widget
     *
     * @return array
     */
    protected function getStats(): array
    {
        // Ambil jumlah role dari database
        $roleCount = Role::count();

        // Kembalikan data statistik yang akan ditampilkan
        return [
            // Label untuk statistik dan nilai statistik
            Stat::make('Total Roles', $roleCount) 
                // Ikon untuk statistik (sesuaikan dengan ikon yang diinginkan)
                ->descriptionIcon('heroicon-o-shield-check', IconPosition::Before) 
                // Deskripsi tambahan
                ->description('Total number of roles in the system')
                ->color('primary'),
        ];
    }
}
