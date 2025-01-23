<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import Navigation from "@/Layouts/Navigation.vue";
import Footer from '@/Components/Footer.vue';

defineProps({
    auth: Object, // Pastikan auth diterima sebagai props
    title: String // Tambahkan title sebagai props
});

// Mengambil properti global dari Inertia.js
const page = usePage();
// Default ke objek kosong untuk menghindari error
const auth = page.props.auth ?? {};

</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        <Head :title="title" />
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

    </div>
</template>
