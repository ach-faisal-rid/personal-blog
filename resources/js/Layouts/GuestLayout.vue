<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import Banner from "@/Components/Banner.vue";
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
        <Head :title="title" />  <!-- Tidak akan error karena title sudah didefinisikan -->

        <Banner />
       
        <!-- Pastikan Navigation diberikan auth -->
        <Navigation :auth="auth" class="sticky top-0 z-50"/>

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
        <Footer class="sticky bottom-0 w-full" />

    </div>
</template>
