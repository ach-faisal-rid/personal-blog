<script setup>
import { defineProps } from "vue";
import { router } from "@inertiajs/vue3"; // Impor router dari Inertia.js

const props = defineProps({
    thumbnail: Object
});

// Fungsi untuk navigasi ke halaman detail
const goToDetail = () => {
    router.get(`/thumbnail/${props.thumbnail.id}`);
};
</script>

<template>
    <div
        @click="goToDetail"
        class="cursor-pointer block overflow-hidden transition-transform transform rounded-lg shadow-xl hover:scale-105 hover:shadow-2xl group"
    >
        <div class="p-4 bg-white dark:bg-gray-800 transition-transform duration-300 group-hover:translate-y-2">
            
            <!-- Thumbnail -->
            <div class="mt-4 relative">
                <img v-if="thumbnail?.url" :src="thumbnail.url" alt="Thumbnail"
                    class="w-32 h-auto object-cover rounded-md transition-all duration-500 group-hover:scale-110" />
                <p v-else class="text-gray-500 dark:text-gray-400 text-sm">Sorry, thumbnail data is not yet available.</p>
            </div>

            <!-- Posted Date -->
            <p class="text-sm text-gray-500 mt-2">
                Posted on: {{ new Date(thumbnail.created_at).toLocaleDateString() }}
            </p>
            
        </div>
    </div>
</template>

<style scoped>
img {
    transition: transform 0.3s ease-in-out;
}

/* Efek hover pada gambar */
.group:hover img {
    transform: scale(1.1);
}
</style>
