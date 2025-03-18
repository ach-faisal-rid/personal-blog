<script>
export default {
    props: {
        post: Object, // Menerima data post
    }
};
</script>

<template>
    <div class="max-w-4xl mx-auto mt-10 mb-10">
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
                    :src="post.thumbnails[0].image_url"
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
</template>