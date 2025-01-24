<script>
export default {
    props: {
        post: Object,
    },
};
</script>

<template>
    <div>
        <h1 class="mb-4 text-4xl font-bold">{{ post.title }}</h1>
        <div v-if="post.youtube_url" class="mb-4">
            <iframe :src="post.youtube_url" frameborder="0" class="w-full h-64"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>
        <p class="text-lg text-gray-700">{{ post.description }}</p>
    </div>
</template>