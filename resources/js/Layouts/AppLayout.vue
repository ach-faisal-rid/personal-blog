<script setup>
import { Head } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import Navigation from '@/Layouts/Navigation.vue';
import Footer from '@/Components/footer.vue';
defineProps({
    title: String,
});
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        < class="min-h-screen bg-gray-100">
            <Navigation />

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
            
            <Footer/>
    </div>
</template>
