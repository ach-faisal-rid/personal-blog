<x-filament::widget>
    <x-filament::card>
        <h2 class="text-lg font-bold">Post Statistics 🚀</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

            <!-- Statistik Total Post -->
            <div class="p-4 bg-blue-100 rounded-lg text-center">
                <p class="text-2xl font-bold">{{ $total }}</p>
                <p>Total Posts</p>
            </div>
            
        </div>
    </x-filament::card>
</x-filament::widget>
