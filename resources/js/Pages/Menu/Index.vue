<script setup>
import { Head } from "@inertiajs/vue3";
import { router } from '@inertiajs/vue3';
import { Music, Image } from 'lucide-vue-next';
import GuestLayout from "@/Layouts/GuestLayout.vue";

const menuItems = [
    { title: "Music", icon: Music, link: "/music" },
    { title: "Thumbnail", icon: Image, link: "/thumbnails" },
];

const navigate = (link) => {
    router.get(link);
};

</script>

<template>

    <Head title="Menu Index" />
    <GuestLayout>
        <div
            class="flex flex-col items-center justify-center min-h-screen bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="flex gap-4 p-4 bg-orange-100 rounded-lg dark:bg-dots-lighter dark:bg-gray-700">
                <div v-for="(item, index) in menuItems" :key="index"
                    class="flex flex-col items-center justify-center w-32 h-20 bg-white rounded-lg shadow-md cursor-pointer hover:bg-gray-100"
                    @click="navigate(item.link)">
                    <component :is="item.icon" class="w-6 h-6 text-gray-700" />
                    <p class="mt-2 text-sm font-semibold text-gray-800">{{ item.title }}</p>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>