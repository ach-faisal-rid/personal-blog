<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useDarkMode } from "@/composables/useDarkMode";

const { isDark } = useDarkMode();
</script>

<template>
    <AppLayout title="Dashboard">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- Konten dashboard Anda di sini -->
                        <p>Selamat datang di dashboard aplikasi!</p>
                        
                        <!-- Contoh elemen dengan dark mode -->
                        <div class="mt-4 p-4 border rounded-lg bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600">
                            <p>Ini adalah contoh card yang responsif terhadap dark mode</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>