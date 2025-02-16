<script setup>
import { ref, onMounted } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import Navigation from "@/Layouts/Navigation.vue";
import Footer from "@/Components/Footer.vue";
import VoxelDog from "@/Components/VoxelDog.vue";

defineProps({
    auth: Object,
    title: String
});

// Mengambil properti global dari Inertia.js
const page = usePage();
const auth = page.props.auth ?? {};

// State untuk mengatur loading
const isLoading = ref(true);

// Simulasi loading selama 2 detik sebelum menampilkan konten utama
onMounted(() => {
    setTimeout(() => {
        isLoading.value = false;
    }, 2000);
});
</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <Head :title="title" />

        <!-- Loading State -->
        <VoxelDog v-if="isLoading" class="flex items-center justify-center min-h-screen" />

        <!-- Konten utama setelah loading selesai -->
        <template v-else>
            <Navigation :auth="auth" />

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow dark:bg-gray-800">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <slot :auth="auth"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>

            <!-- Footer -->
            <Footer />
        </template>
    </div>
</template>