<script>
import { Head } from "@inertiajs/vue3";
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PostDetail from './PostDetail.vue';

export default {
    props: {
        post: Object,
    },
    mounted() {
        console.log(this.post);
    },
};

</script>

<template>
    <GuestLayout>
        <Head title="Show Post" />
        <div
            class="flex flex-col items-center justify-center min-h-screen bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
        >
            <!-- Judul Post dan Detail -->
                <!-- <PostDetail :post="post" /> -->

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ post.title }}</h1>

            <!-- Date -->
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Posted on: {{ new Date(post.created_at).toLocaleDateString() }}
            </p>

            <!-- Thumbnail -->
            <div class="mt-4 relative">
                <img
                    v-if="post.thumbnails.length > 0"
                    :src="post.thumbnails[0].url"
                    alt="Thumbnail"
                    class="w-full h-auto rounded-md transition-all duration-500"
                />
                <p v-else class="text-gray-500 dark:text-gray-400 text-sm">Maaf, data thumbnail belum tersedia.</p>
            </div>

            <!-- Categories & Authors -->
            <div class="mt-4 flex justify-between">
                <div>
                    <strong>Categories:</strong>
                    <ul class="list-none pl-0">
                        <li v-for="category in post.categories" :key="category.id">
                            {{ category.name }}
                        </li>
                    </ul>
                </div>

                <div>
                    <strong>Authors:</strong>
                    <ul class="list-none pl-0">
                        <li v-for="author in post.authors" :key="author.id">
                            {{ author.name }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Comments -->
            <div v-if="post.comments.length > 0" class="mt-4">
                <strong>Comments:</strong>
                <ul class="list-none pl-0">
                    <li v-for="comment in post.comments" :key="comment.id">
                        <p><strong>{{ comment.post_user.user.name }}:</strong> {{ comment.comment }}</p>
                    </li>
                </ul>
            </div>
            <div v-else class="mt-4 text-sm text-gray-500">
                No comments yet.
            </div>

            <!-- Description -->
            <div v-if="post.description" class="mt-4">
                <strong>Description:</strong>
                <p class="text-gray-600 dark:text-gray-400">{{ post.description }}</p>
            </div>

            <!-- YouTube Video -->
            <div v-if="post.youtube_url" class="mt-4">
                <a :href="post.youtube_url" target="_blank" class="text-blue-600 hover:underline">
                    Watch the video on YouTube
                </a>
            </div>
        </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
/* Background untuk tema gelap dan terang */
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
    transition: background-color 0.5s ease, background-image 0.5s ease;
}

.dark .bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    transition: background-color 0.5s ease, background-image 0.5s ease;
}

/* Desain Artikel dan Berita */
.bg-white {
    background-color: #ffffff;
}

.rounded-lg {
    border-radius: 8px;
}

.shadow-lg {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Styling untuk kontainer */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

/* Sticky Header */
.sticky-header {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: rgba(255, 255, 255, 0.8);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Tampilan background yang lebih baik pada tema gelap */
.dark .bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    transition: background-color 0.5s ease, background-image 0.5s ease;
}
</style>