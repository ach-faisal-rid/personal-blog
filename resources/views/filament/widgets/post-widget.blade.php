<x-filament::widget>
    <x-filament::card class="p-4">
        <h2 class="text-lg font-bold mb-3">Post Statistics 🚀</h2>
        <div class="flex justify-center">
            <!-- Statistik Total Post -->
            <div class="px-4 py-3 bg-blue-100 rounded-lg text-center w-full max-w-[200px]">
                <p class="text-2xl font-bold">{{ $total }}</p>
                <p class="text-sm">Total Posts</p>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>