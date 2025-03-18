<script>

export default {
    props: {
        thumbnail: Object, // Menerima data thumbnail
    }
};

</script>

<template>
    <div class="max-w-4xl mx-auto mt-10 mb-10">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            
            <!-- Thumbnail -->
            <div class="mt-4 relative">
                <img v-if="thumbnail?.image_url" :src="thumbnail.image_url" alt="Thumbnail"
                    class="w-32 h-auto object-cover rounded-md transition-all duration-500 group-hover:scale-110" />
                <p v-else class="text-gray-500 dark:text-gray-400 text-sm">Sorry, thumbnail data is not yet available.
                </p>
            </div>

            <!-- Posted Date -->
            <p class="text-sm text-gray-500 mt-2">
                Posted on: {{ new Date(thumbnail.created_at).toLocaleDateString() }}
            </p>

        </div>
    </div>
</template>