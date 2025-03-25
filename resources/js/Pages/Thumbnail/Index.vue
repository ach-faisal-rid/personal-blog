<script setup>
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import ThumbnailCard from "./ThumbnailCard.vue";

// Data Thumbnails
const props = defineProps({
    thumbnails: Object,
});

// State untuk sorting
const sortBy = ref("latest");

// Fungsi untuk mengambil data dengan sorting
const applyFilters = () => {
    router.get(route("thumbnail.index"), {
        sort: sortBy.value
    }, {
        preserveState: true, // Agar tidak reload halaman
        replace: true,       // Supaya tidak menambah history
    });
};

// Method untuk navigasi pagination
function fetchPage(url) {
    router.get(url, {}, { preserveState: true, replace: true });
}

</script>

<template>
    <Head title="📷 Thumbnail Index" />
    <GuestLayout>
        <div class="flex flex-col items-center justify-center min-h-screen bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

            <h1 class="text-2xl font-bold mb-4 mt-5 dark:text-white">Thumbnail List</h1>

            <!-- Sorting -->
            <div class="flex gap-4 mb-6">

                <!-- Select Sorting -->
                <select
                    v-model="sortBy" 
                    class="p-3 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    @change="applyFilters"
                >
                    <option value="latest" class="text-gray-900">🆕 Terbaru</option>
                    <option value="oldest" class="text-gray-900">📅 Terlama</option>
                </select>
            </div>

            <!-- Grid Layout -->
            <div class="mt-10 px-4 max-w-lg mx-auto max-w-7xl">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <ThumbnailCard 
                        v-for="thumbnail in thumbnails.data" 
                        :key="thumbnail.id" 
                        :thumbnail="thumbnail" 
                    />
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4 flex items-center space-x-2">
                <template v-if="thumbnails.links">
                    <button v-for="(link, index) in thumbnails.links" :key="index" 
                        @click="fetchPage(link.url)" 
                        v-html="link.label" 
                        v-show="link.url !== null"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 mb-4"
                        :class="{ 'bg-blue-500 text-white': link.active }">
                    </button>
                </template>
            </div>

        </div>
    </GuestLayout>
</template>
