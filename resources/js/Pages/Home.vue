<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import { useDarkMode } from "@/composables/useDarkMode"; // Import composable
import GuestLayout from "@/Layouts/GuestLayout.vue";

// Ambil properti global dari Inertia
const page = usePage();
const auth = page.props.auth ?? {}; // Mencegah error jika auth undefined

// Definisikan props yang diterima oleh komponen ini
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

// Menggunakan composable untuk dark mode
const { isDark, toggleDarkMode } = useDarkMode();
</script>

<template>
    <Head title="Home" />
    <GuestLayout>
        <div
            class="relative min-h-screen bg-gray-100 bg-center sm:flex sm:justify-center sm:items-center bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white">
                    Hello, Selamat Datang di Laravel
                </h1>

                <!-- Tampilkan link dashboard jika sudah login -->
                <div v-if="auth?.user" class="z-10 p-6 sm:fixed sm:top-0 sm:end-0 text-end">
                    <Link :href="route('dashboard')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                        Dashboard
                    </Link>
                </div>
            </div>

            <!-- Tombol untuk toggle dark mode di kiri atas -->
            <div class="absolute top-4 left-4">
                <button @click="toggleDarkMode"
                    class="p-2 transition-all duration-300 ease-in-out transform bg-gray-200 rounded-full dark:bg-gray-800 hover:scale-110">
                    <span v-if="isDark" class="text-white">🌞</span>
                    <span v-else class="text-gray-800">🌙</span>
                </button>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
/* Transisi pada elemen background dan warna */
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
    transition: background-color 0.5s ease, background-image 0.5s ease;
}

.dark .bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    transition: background-color 0.5s ease, background-image 0.5s ease;
}

button {
    transition: background-color 0.3s ease;
}
</style>
