<script setup>
import { Head } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { ref } from "vue";

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
});
</script>

<template>
    <Head title="Home" />
    <GuestLayout>
        
        <div
            class="flex flex-col items-center justify-center min-h-screen bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
        >
            <!-- Introduction -->
            <div
                class="mb-8 p-4 mt-12 text-center bg-gray-200 shadow-md rounded-2xl dark:bg-gray-800"
            >
                <p class="text-xl font-semibold dark:text-white">
                    Hello, I'm an indie app developer based in
                    {{ profile.location }}!
                </p>
            </div>

            <!-- Profile Section -->
            <div class="flex flex-col md:flex-row items-center gap-6">
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
            <div class="mt-12 max-w-lg mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Work
                </h3>
                <p
                    class="mt-2 text-gray-600 dark:text-gray-400 leading-relaxed"
                >
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
            <div class="mt-10 max-w-lg mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Bio
                </h3>
                <ul class="mt-2">
                    <li
                        v-for="(item, index) in profile.bio"
                        :key="index"
                        class="text-gray-600 dark:text-gray-400"
                    >
                        <strong class="text-teal-500">{{ item.year }}</strong>
                        - {{ item.text }}
                    </li>
                </ul>
            </div>

            <!-- Interests Section -->
            <div class="mt-10 max-w-lg mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    I ♥
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ profile.interests.join(", ") }}
                </p>
            </div>

            <!-- Social Links -->
            <div class="mt-10 max-w-lg mx-auto">
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

            <!-- grid layout -->
            <div class="mt-10 px-4 max-w-lg mx-auto max-w-7xl">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <a
                        href="https://www.youtube.com/@ach-faisal-rid"
                        target="_blank"
                        class="block overflow-hidden transition-transform transform rounded-lg shadow-xl hover:scale-105 hover:shadow-2xl group"
                    >
                        <img
                            src="https://i.pinimg.com/736x/3b/a8/04/3ba8040d055d897b1581949eedf29b73.jpg"
                            alt="ach-faisal-rid"
                            class="w-full h-auto object-cover transition-transform duration-300 group-hover:scale-110"
                        />
                        <div
                            class="p-4 bg-white dark:bg-gray-800 transition-transform duration-300 group-hover:translate-y-2"
                        >
                            <h3
                                class="text-lg font-bold text-gray-900 dark:text-white"
                            >
                                faisal ach rid
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                My YouTube channel (&gt; 31 subs)
                            </p>
                        </div>
                    </a>

                    <a
                        href="#"
                        target="_blank"
                        class="block overflow-hidden transition-transform transform rounded-lg shadow-xl hover:scale-105 hover:shadow-2xl group"
                    >
                        <img
                            src="https://i.pinimg.com/736x/97/00/60/9700602e0a37db9dcbe3cef6948040e5.jpg"
                            alt="netdown"
                            class="w-full h-auto object-cover transition-transform duration-300 group-hover:scale-110"
                        />
                        <div
                            class="p-4 bg-white dark:bg-gray-800 transition-transform duration-300 group-hover:translate-y-2"
                        >
                            <h3
                                class="text-lg font-bold text-gray-900 dark:text-white"
                            >
                                netdown
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                A Markdown note-taking app
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="mt-10 max-w-lg mx-auto">
                <!-- Section Title -->
                <h3
                    class="inline-block mb-4 text-2xl font-bold border-b-2 
                    border-teal-500 text-gray-900 dark:text-white"
                >
                    Newsletter
                </h3>

                <!-- Description -->
                <p class="text-gray-600 dark:text-gray-400">
                    Join me on a behind-the-scenes coding journey. Weekly
                    updates on projects, tutorials, and videos
                </p>

                <!-- Button -->
                <div class="my-4 text-center mb-10">
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

/* Transisi pada elemen background dan warna */
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
    transition: background-color 0.5s ease, background-image 0.5s ease;
}

.dark .bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    transition: background-color 0.5s ease, background-image 0.5s ease;
}

/* Sticky header */
.sticky-header {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: rgba(255, 255, 255, 0.8);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Artikel dan berita dengan desain lebih baik */
.bg-white {
    background-color: #ffffff;
}

.rounded-lg {
    border-radius: 8px;
}

.shadow-lg {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>