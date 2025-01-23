<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import { useDarkMode } from "@/composables/useDarkMode"; // Import composable
import GuestLayout from "@/Layouts/GuestLayout.vue";

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

            <!-- Konten utama dengan lebar terbatas -->
            <div class="container px-4 py-10 mx-auto">
                <div class="text-center">

                    <div class="inline-block px-6 py-4 bg-gray-200 shadow-md dark:bg-gray-800 rounded-2xl">
                        <h1 class="text-4xl font-bold text-gray-800 md:text-5xl dark:text-white">
                            Hi, I'm an indie web developer based in Indonesia!
                        </h1>
                    </div>

                    <div
                        class="flex flex-col items-center justify-center mt-6 space-y-2 md:flex-row md:space-y-0 md:space-x-6">
                        <h2 class="text-2xl font-semibold text-gray-700 md:text-3xl dark:text-gray-300">
                            Faisal Achmad Ridhani
                        </h2>
                        <p class="text-lg text-gray-600 md:text-xl dark:text-gray-400">
                            Digital Craftsman (Developer/Designer)
                        </p>
                    </div>
                </div>

                <!-- Tambahkan beberapa konten berita atau artikel -->
                <div class="mt-8 space-y-6">
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <h2 class="text-2xl font-semibold text-gray-800">Berita Terbaru</h2>
                        <p class="mt-2 text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                            gravida mi id eros vulputate, vel placerat magna dictum.</p>
                    </div>
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <h2 class="text-2xl font-semibold text-gray-800">Topik Terhangat</h2>
                        <p class="mt-2 text-gray-600">Curabitur euismod dolor at urna tempor, vitae dignissim lectus
                            volutpat. Nunc id dolor sit amet libero sodales suscipit.</p>
                    </div>
                    <!-- Tambahkan lebih banyak artikel atau berita di sini -->
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

/* Kontainer untuk konten berita atau artikel */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Sticky header */
.sticky-header {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: rgba(255, 255, 255, 0.8);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Artikel dan berita dengan desain lebih baik */
.bg-white {
    background-color: #ffffff;
}

.rounded-lg {
    border-radius: 8px;
}

.shadow-lg {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>