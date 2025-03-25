<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PostCard from "./PostCard.vue";

// Data Posts
defineProps({
    posts: Object,
});

// State untuk filter dan sorting
const searchText = ref(""); // Filter pencarian
const sortBy = ref("latest"); // Default sorting

// Fungsi untuk mengambil data dengan filter dan sorting
const applyFilters = () => {
    router.get(route("posts.index"), { 
        filter: searchText.value,
        sort: sortBy.value
    }, {
        preserveState: true, // Supaya tidak reload halaman
        replace: true,       // Agar tidak menambah history
    });
};

// Method untuk navigasi pagination
function fetchPage(url) {
    router.get(url, {}, { preserveState: true, replace: true });
}

</script>

<template>

    <Head title="📮 Post Index" />
    <GuestLayout>
        <div
            class="flex flex-col items-center justify-center min-h-screen bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
        >

            <h1 class="text-2xl font-bold mb-4 mt-5 dark:text-white">Popular Posts</h1>

            <!-- Filter & Sorting -->
            <div class="flex gap-4 mb-6">
                <!-- Input Search -->
                <input 
                    v-model="searchText" 
                    type="text" 
                    placeholder="Cari postingan..." 
                    class="p-2 border rounded"
                    @keyup.enter="applyFilters"
                />

                <!-- Tombol Cari -->
                <button 
                    class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg shadow-md hover:from-blue-600 hover:to-blue-700 hover:shadow-lg transition-all duration-300"
                    @click="applyFilters"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0a7 7 0 1 0-9.9-9.9 7 7 0 0 0 9.9 9.9z"></path>
                    </svg>
                    Cari
                </button>

                <!-- Select Sorting -->
                <select 
                    v-model="sortBy" 
                    class="p-3 border rounded-lg shadow-sm bg-white text-gray-700 focus:ring-2 focus:ring-blue-500"
                    @change="applyFilters"
                >
                    <option value="latest">🆕 Terbaru</option>
                    <option value="oldest">📅 Terlama</option>
                </select>
            </div>

            <!-- grid layout -->
            <div class="mt-10 px-4 max-w-lg mx-auto max-w-7xl">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <PostCard v-for="post in posts.data" :key="post.id" :post="post" />
                </div>

            </div>

            <!-- Pagination -->
            <div class="mt-4 flex items-center space-x-2">

                <template v-if="posts.links">
                    <button v-for="(link, index) in posts.links" :key="index" @click="fetchPage(link.url)"
                        v-html="link.label" v-show="link.url !== null"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 mb-4"
                        :class="{ 'bg-blue-500 text-white': link.active }">
                    </button>
                </template>

            </div>

        </div>
    </GuestLayout>
</template>

<style scoped>
.container {
    max-width: 800px !important;
    margin: 0 auto;
    padding: 20px;
}

/* Transisi pada elemen background dan warna */
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
    transition: background-color 0.5s ease, background-image 0.5s ease;
}

.dark .bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    transition: background-color 0.5s ease, background-image 0.5s ease;
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
