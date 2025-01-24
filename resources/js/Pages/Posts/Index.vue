<script setup>
import { usePage } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";

const { posts } = usePage().props;
console.log(posts);
</script>

<template>
    <Head title="Posts landing" />
    <GuestLayout>
        <div
        class="flex flex-col items-center justify-start min-h-screen bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <h1
            class="mt-12 mb-8 text-3xl font-bold text-gray-800 dark:text-white"
        >
            All Posts
        </h1>

        <!-- Menampilkan daftar post jika ada posts -->
        <div v-if="posts.length" class="grid grid-cols-1 gap-6 sm:grid-cols-2 w-full max-w-xl px-4 sm:px-6 lg:px-8 mx-auto mb-8">
            <div v-for="post in posts" :key="post.id" class="p-4 transition-shadow duration-300 bg-white rounded-lg shadow-md hover:shadow-lg">
                <h2 class="text-2xl font-semibold text-indigo-600">
                    <Link :href="route('post.show', post.id)" class="hover:underline">{{ post.title }}</Link>
                </h2>
                <p class="mt-2 text-gray-600">{{ post.description }}</p>

                <!-- Menampilkan youtube_url jika ada -->
                <div v-if="post.youtube_url" class="mt-2">
                    <iframe 
                        width="100%" 
                        height="315" 
                        :src="post.youtube_url" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Jika tidak ada post yang tersedia -->
        <div v-else class="text-center text-gray-500">
            No posts available.
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
</style>
