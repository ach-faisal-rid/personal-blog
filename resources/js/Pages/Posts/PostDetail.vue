<script setup>
import { Head } from '@inertiajs/vue3'

// Props dari Laravel controller
defineProps({
    post: Object,
})
</script>

<template>
    <Head :title="post.title" />

    <div class="max-w-4xl mx-auto mt-10 mb-10">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ post.title }}</h1>

            <!-- Date -->
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Posted on: {{ new Date(post.created_at).toLocaleDateString() }}
            </p>

            <!-- Thumbnail -->
            <div class="mt-4">
                <img
                    v-if="post.thumbnail"
                    :src="post.thumbnail.image_url"
                    alt="Thumbnail"
                    class="w-full h-auto rounded-md transition-all duration-500"
                />
                <p v-else class="text-gray-500 dark:text-gray-400 text-sm">
                    Maaf, data thumbnail belum tersedia.
                </p>
            </div>

            <!-- Category & Author -->
            <div class="mt-6 flex flex-col sm:flex-row sm:justify-between gap-4">
                <div>
                    <strong class="text-gray-700 dark:text-gray-300">Category:</strong>
                    <div v-if="post.category" class="flex items-center gap-2 text-gray-800 dark:text-gray-200 mt-1">
                        {{ post.category.name }}
                    </div>
                </div>

                <div>
                    <strong class="text-gray-700 dark:text-gray-300">Author:</strong>
                    <p v-if="post.author" class="text-gray-800 dark:text-gray-200 mt-1">
                        {{ post.author.name }}
                    </p>
                </div>
            </div>

            <!-- Description -->
            <div v-if="post.description" class="mt-6">
                <strong class="text-gray-700 dark:text-gray-300">Description:</strong>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ post.description }}</p>
            </div>

            <!-- Social URL -->
            <div v-if="post.social_url" class="mt-6">
                <a
                    :href="post.social_url"
                    target="_blank"
                    class="text-blue-600 hover:underline dark:text-blue-400"
                >
                    Watch the video on social media
                </a>
            </div>
        </div>
    </div>
</template>
