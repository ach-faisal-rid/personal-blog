<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use Carbon\Carbon;

class UserStats extends ChartWidget
{
    // Heading untuk widget
    protected static ?string $heading = 'User Statistics';

    // Jenis chart (bisa diubah ke 'bar', 'pie', dll.)
    protected static ?string $type = 'line';

    protected function getData(): array
    {
        // Mengambil data jumlah pengguna per bulan dalam setahun terakhir
        $usersPerMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Memetakan data ke format yang sesuai
        $data = [];
        $labels = [];

        foreach (range(1, 12) as $month) {
            $labels[] = Carbon::create()->month($month)->format('F'); // Nama bulan
            $data[] = $usersPerMonth->firstWhere('month', $month)->count ?? 0; // Jumlah pengguna
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => $data,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Warna chart
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        // Tetapkan jenis chart (sesuai properti statis $type)
        return static::$type;
    }
}
