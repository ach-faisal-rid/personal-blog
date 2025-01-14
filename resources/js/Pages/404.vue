<script setup>
import { Link } from '@inertiajs/vue3';  // Import Link dari Inertia
import { useDarkMode } from '@/composables/useDarkMode'; // Import composable yang sama untuk dark mode

// Menggunakan composable untuk dark mode
const { isDark } = useDarkMode(); 
</script>

<template>
    <div :class="{ 'dark': isDark.value }" class="min-h-screen flex items-center justify-center p-6">
        <div class="text-center bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8 space-y-4">
            <img src="https://i.pinimg.com/736x/17/24/01/172401ae7a8820b771bb2de5779f6d1e.jpg" alt="Lost Page"
                class="mx-auto mb-6 w-32 h-32 object-cover animate-bounce" />
            <h1 class="text-6xl font-extrabold text-red-500 dark:text-red-400">
                Ups! <span class="text-xl">Halaman yang Anda cari sedang berlibur</span>
            </h1>
            <p class="text-lg text-gray-700 dark:text-gray-300">
                Sepertinya Anda tersesat. Halaman ini sedang dalam perbaikan, atau bahkan bisa jadi hilang!
            </p>
            <p class="text-lg text-gray-700 dark:text-gray-300">
                Tapi jangan khawatir, kami akan membantu Anda menemukan jalan pulang.
            </p>
            <!-- Gunakan Link dari @inertiajs/vue3 -->
            <Link :href="route('home')"
                class="inline-block px-6 py-2 mt-4 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all">
            Kembali ke Beranda
            </Link>
            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                Aduh, halamannya hilang! <span role="img" aria-label="lost">🙈</span>
            </p>
        </div>
    </div>
</template>

<style scoped>
/* Animasi bouncing untuk gambar */
@keyframes bounce {
    0% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-10px);
    }

    100% {
        transform: translateY(0);
    }
}

.animate-bounce {
    animation: bounce 1s infinite;
}

/* Menetapkan background pada kondisi gelap */
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
    transition: background-color 0.5s ease, background-image 0.5s ease;
}

/* Background dots berubah saat dark mode */
.dark .bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    transition: background-color 0.5s ease, background-image 0.5s ease;
}

.bg-gray-100 {
    background-color: #f7fafc; /* Default background color */
}

.dark .bg-gray-800 {
    background-color: #2d3748; /* Dark background color */
}
</style>
