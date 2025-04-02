<script setup>
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";

// Data profil
const profile = ref({
    name: "Faisal Achmad Ridhani",
    job: "Digital Craftsman ( Artist / Developer / Designer )",
    location: "Jombang, Indonesia",
    bio: [
        { year: "2000", text: "Born in Jombang, Indonesia." },
        { year: "2016", text: "my journey begin as a web developer." },
        {
            year: "2019",
            text: "i retire about web developer an in this year i start to learn to sell product",
        },
        {
            year: "2022",
            text: "i comeback to batch 2 journey as a web developer.",
        },
    ],
    interests: [
        "Art",
        "Music",
        "Drawing",
        "Playing Drums",
        "Photography",
        "Machine Learning",
    ],
    socialLinks: [
        {
            name: "GitHub",
            url: "https://github.com/ach-faisal-rid",
            icon: "🐙",
        },
        {
            name: "Medium (EN)",
            url: "https://medium.com/@raddians",
            icon: "📖 ",
        },
        {
            name: "Twitter (EN)",
            url: "https://twitter.com/pencarikatak",
            icon: "🐦",
        },
        {
            name: "Instagram",
            url: "https://instagram.com/ach_ridhn",
            icon: "📸",
        },
    ],

    gridLinks : [
        {
            name : "youtube",
            url : "https://www.youtube.com/@ach-faisal-rid",
            image : "http://localhost:8000/storage/profile-photos/I6Z64RINAoOh1F64oAkI1Epx4CRcrbfToLBH7eM7.png",
        }
    ]
});

</script>

<template>
    <Head title="Home" />

    <GuestLayout>
        <div
            class="container relative min-h-screen px-4 py-10 mx-auto bg-gray-100 bg-center bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900"
        >
            <!-- Introduction -->
            <div
                class="p-4 mb-6 text-center bg-gray-200 shadow-md rounded-2xl dark:bg-gray-800"
            >
                <p class="text-xl font-semibold dark:text-white">
                    Hello, I'm an indie app developer based in
                    {{ profile.location }}!
                </p>
            </div>

            <!-- Profile Section -->
            <div class="flex flex-col items-center md:flex-row">
                <div class="flex-1 text-center md:text-left">
                    <h2
                        class="text-3xl font-bold text-gray-900 dark:text-white"
                    >
                        {{ profile.name }}
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        {{ profile.job }}
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <img
                        src="http://localhost:8000/storage/profile-photos/UYZQQzqQbAR5CYlId1YLNeLWmdlGrEtbHZ3YIWd5.jpg"
                        alt="Profile image"
                        class="w-24 h-24 border-2 border-gray-300 rounded-full"
                    />
                </div>
            </div>

            <!-- Work Section -->
            <div class="mt-10">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Work
                </h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Faisal is a freelance full-stack developer based in Jombang
                    with a passion for building digital services.
                </p>
                <div class="mt-4 text-center">
                    <Link
                        href="/works"
                        class="px-6 py-2 text-white bg-teal-500 rounded-md"
                        >My Portfolio</Link
                    >
                </div>
            </div>

            <!-- Bio Section -->
            <div class="mt-10">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Bio
                </h3>
                <ul class="mt-2">
                    <li
                        v-for="(item, index) in profile.bio"
                        :key="index"
                        class="text-gray-600 dark:text-gray-400"
                    >
                        <strong class="text-teal-500">{{ item.year }}</strong> -
                        {{ item.text }}
                    </li>
                </ul>
            </div>

            <!-- Interests Section -->
            <div class="mt-10">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    I ♥
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ profile.interests.join(", ") }}
                </p>
            </div>

            <!-- Social Links -->
            <div class="mt-10">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    On the web
                </h3>
                <div class="flex flex-wrap gap-4 mt-2">
                    <a
                        v-for="(link, index) in profile.socialLinks"
                        :key="index"
                        :href="link.url"
                        target="_blank"
                        class="flex items-center gap-2 px-4 py-2 text-gray-800 bg-gray-100 rounded-md dark:bg-gray-700 dark:text-white"
                    >
                        {{ link.icon }} {{ link.name }}
                    </a>
                </div>
            </div>

            <!--  -->
            <div class="px-4 mx-auto max-w-7xl">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <a
                        v-for="(link, index) in gridLinks"
                        :key="index"
                        :href="link.url"
                        target="_blank"
                        class="block overflow-hidden transition-transform transform rounded-lg shadow-md hover:scale-105"
                    >
                        <img
                            :src="link.image"
                            :alt="link.name"
                            class="w-full h-auto"
                        />
                        <div class="p-4">
                            <h3 class="text-lg font-bold">{{ link.name }}</h3>
                            <p>My YouTube channel (&gt; 31 subs)</p>
                        </div>
                    </a>

                    <a
                        href="#"
                        target="_blank"
                        class="block overflow-hidden transition-transform transform rounded-lg shadow-md hover:scale-105"
                    >
                        <img
                            :src="thumbfakenote"
                            alt="fakenote"
                            class="w-full h-auto"
                        />
                        <div class="p-4">
                            <h3 class="text-lg font-bold">fakenote</h3>
                            <p>A Markdown note-taking app</p>
                        </div>
                    </a>
                </div>
            </div>

            <div>
                <!-- Section Title -->
                <h3
                    class="inline-block mb-4 text-2xl font-bold border-b-2 border-teal-500"
                >
                    Newsletter
                </h3>

                <!-- Description -->
                <p class="text-gray-600">
                    Join me on a behind-the-scenes coding journey. Weekly
                    updates on projects, tutorials, and videos
                </p>

                <!-- Button -->
                <div class="my-4 text-center">
                    <a
                        href="#"
                        target="_blank"
                        class="inline-flex items-center px-6 py-3 text-white transition-all bg-teal-500 rounded-lg shadow-md hover:bg-teal-600"
                    >
                        <span class="mr-2">📧</span>
                        Sign up my newsletter here
                    </a>
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
</style>
