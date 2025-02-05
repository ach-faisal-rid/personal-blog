<script>
export default {
    props: {
        post: Object
    }
};
</script>

<template>
    <div
        class="block overflow-hidden transition-transform transform rounded-lg shadow-xl hover:scale-105 hover:shadow-2xl group"
    >
        <div
            class="p-4 bg-white dark:bg-gray-800 transition-transform duration-300 group-hover:translate-y-2"
        >
            <!-- Title -->
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <a :href="`/post/${post.id}`" class="hover:underline">
                    {{ post.title }}
                </a>
            </h3>

            <!-- Thumbnail -->
            <div class="mt-4 relative">
                <img
                    v-if="post.thumbnails.length > 0"
                    :src="post.thumbnails[0].url"
                    alt="Thumbnail"
                    class="w-32 h-auto object-cover rounded-md transition-all duration-500 group-hover:scale-110"
                />
                <p v-else class="text-gray-500 dark:text-gray-400 text-sm">Sorry, thumbnail data is not yet available.</p>
            </div>

            <!-- Posted Date -->
            <p class="text-sm text-gray-500 mt-2">
                Posted on: {{ new Date(post.created_at).toLocaleDateString() }}
            </p>

            <div class="mt-4 flex justify-between space-x-4">
                <!-- Categories -->
                <div v-if="post.categories.length > 0" class="mt-4">
                    <strong class="text-gray-700 dark:text-gray-300">Categories:</strong>
                    <ul class="pl-5 text-gray-600 dark:text-gray-400 list-none">
                        <li v-for="category in post.categories" :key="category.id">
                            {{ category.name }}
                        </li>
                    </ul>
                </div>
                <div v-else class="mt-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Sorry, category data is not yet available.</p>
                </div>
    
                <!-- Authors -->
                <div v-if="post.authors.length > 0" class="mt-4">
                    <strong class="text-gray-700 dark:text-gray-300">Authors:</strong>
                    <ul class="pl-5 text-gray-600 dark:text-gray-400 list-none">
                        <li v-for="author in post.authors" :key="author.id">
                            {{ author.name }}
                        </li>
                    </ul>
                </div>
                <div v-else class="mt-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Sorry, author data is not yet available.</p>
                </div>
            </div>

        </div>
    </div>
</template>

<style scoped>
img {
    transition: transform 0.3s ease-in-out;
}

/* Efek hover pada gambar */
.group:hover img {
    transform: scale(1.05);
}
</style>
