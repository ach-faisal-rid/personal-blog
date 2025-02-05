<script setup>
import { Head } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PostCard from "./PostCard.vue";

// Data Posts
defineProps({
    posts: Object,
});

// Function for navigation
function fetchPage(url) {
  Inertia.get(url);
}
</script>

<template>
    <Head title="Post Index" />
    <GuestLayout>
        <div
            class="flex flex-col items-center justify-center min-h-screen bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
        >
            <h1 class="text-2xl font-bold mb-6">Popular Posts</h1>
            <!-- grid layout -->
            <div class="mt-10 px-4 max-w-lg mx-auto max-w-7xl">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <PostCard
                        v-for="post in posts.data"
                        :key="post.id"
                        :post="post"
                    />
                </div>
                
                <!-- Pagination -->
                <div class="mt-4 flex justify-between">
                    <button
                        v-if="posts.links.prev"
                        @click="fetchPage(posts.links.prev)"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                    >
                        Previous
                    </button>
                    <button
                        v-if="posts.links.next"
                        @click="fetchPage(posts.links.next)"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                    >
                        Next
                    </button>
                </div>
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
