<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

// Data profil
const profile = ref({
    name: 'Faisal Achmad Ridhani',
    job: 'Digital Craftsman ( Artist / Developer / Designer )',
    location: 'Jombang, Indonesia',
    bio: [
        { year: '2000', text: 'Born in Osaka (大阪), Japan.' },
        { year: '2016', text: 'my journey begin as a web developer.' },
        { year: '2019', text: 'i retire about web developer an in this year i start to learn to sell product' },
        { year: '2022', text: 'i comeback to batch 2 journey as a web developer.' },
    ],
    interests: ['Art', 'Music', 'Drawing', 'Playing Drums', 'Photography', 'Machine Learning'],
    socialLinks: [
        { name: 'GitHub', url: 'https://github.com/ach-faisal-rid', icon: '🐙' },
        { name: 'Medium (EN)', url: 'https://medium.com/@raddians', icon: '📖 ' },
        { name: 'Twitter (EN)', url: 'https://twitter.com/pencarikatak', icon: '🐦' },
        { name: 'Instagram', url: 'https://instagram.com/ach_ridhn', icon: '📸' }
    ]
});

</script>

<template>

    <Head title="Home" />

    <GuestLayout>
        <div class="container px-4 py-10 mx-auto">
            <!-- Introduction -->
            <div class="p-4 mb-6 text-center bg-gray-200 shadow-md dark:bg-gray-800 rounded-2xl">
                <p class="text-xl font-semibold dark:text-white">
                    Hello, I'm an indie app developer based in {{ profile.location }}!
                </p>
            </div>

            <!-- Profile Section -->
            <div class="flex flex-col items-center md:flex-row">
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ profile.name }}
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        {{ profile.job }}
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <img src="http://localhost:8000/storage/profile-photos/UYZQQzqQbAR5CYlId1YLNeLWmdlGrEtbHZ3YIWd5.jpg"
                        alt="Profile image" class="w-24 h-24 border-2 border-gray-300 rounded-full" />
                </div>
            </div>

            <!-- Work Section -->
            <div class="mt-10">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Work</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Takuya is a freelance full-stack developer based in Osaka with a passion for building digital
                    services.
                    He runs a product called
                    <Link href="/works/inkdrop" class="text-teal-500">Inkdrop</Link> and a YouTube
                    channel "<a href="https://www.youtube.com/devaslife" target="_blank" class="text-teal-500">Dev as
                        Life</a>"
                    with over 100k subscribers.
                </p>
                <div class="mt-4 text-center">
                    <Link href="/works" class="px-6 py-2 text-white bg-teal-500 rounded-md">My Portfolio</Link>
                </div>
            </div>

            <!-- Bio Section -->
            <div class="mt-10">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Bio</h3>
                <ul class="mt-2">
                    <li v-for="(item, index) in profile.bio" :key="index" class="text-gray-600 dark:text-gray-400">
                        <strong class="text-teal-500">{{ item.year }}</strong> - {{ item.text }}
                    </li>
                </ul>
            </div>

            <!-- Interests Section -->
            <div class="mt-10">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">I ♥</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ profile.interests.join(', ') }}
                </p>
            </div>

            <!-- Social Links -->
            <div class="mt-10">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">On the web</h3>
                <div class="flex flex-wrap gap-4 mt-2">
                    <a v-for="(link, index) in profile.socialLinks" :key="index" :href="link.url" target="_blank"
                        class="flex items-center gap-2 px-4 py-2 text-gray-800 bg-gray-100 rounded-md dark:bg-gray-700 dark:text-white">
                        {{ link.icon }} {{ link.name }}
                    </a>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
.container {
    max-width: 800px;
}
</style>