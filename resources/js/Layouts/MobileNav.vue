<script setup>
import { usePage, router } from '@inertiajs/vue3';
import ResponsiveNavLink from '../Components/ResponsiveNavLink.vue';

const page = usePage();
const auth = page.props.auth ?? {};
const canRegister = true;

const logout = () => {
    router.post(route('logout'), {}, {
        onSuccess: () => {
            page.props.auth.user = null;
            router.visit(route('home'), { replace: true });
        }
    });
};
</script>

<template>
    <div class="bg-gray-100 sm:hidden dark:bg-gray-900">
        <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink v-if="auth?.user" :href="route('profile.show')">Profile</ResponsiveNavLink>
            <ResponsiveNavLink v-if="auth?.user" :href="route('dashboard')">Dashboard</ResponsiveNavLink>
            <form @submit.prevent="logout">
                <ResponsiveNavLink v-if="auth?.user" as="button">Log Out</ResponsiveNavLink>
            </form>
            <ResponsiveNavLink v-if="!auth?.user" :href="route('login')">Login</ResponsiveNavLink>
            <ResponsiveNavLink v-if="!auth?.user && canRegister" :href="route('register')">Register</ResponsiveNavLink>
        </div>
    </div>
</template>