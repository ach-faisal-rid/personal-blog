<script setup>
import { usePage, router, Link } from "@inertiajs/vue3";
import Dropdown from "../Components/Dropdown.vue";
import DropdownLink from "../Components/DropdownLink.vue";

const page = usePage();
const auth = page.props.auth ?? {};
const pageUrl = page.url;

const logout = () => {
    router.post(
        route("logout"),
        {},
        {
            onSuccess: () => {
                page.props.auth.user = null;
                router.visit(route("home"), { replace: true });
            },
        }
    );
};
</script>

<template>
    <div class="flex items-center space-x-6">

        <template v-if="!auth?.user">
            <Link
                :href="route('login')"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white"
            >
                Login
            </Link>
            <Link
                :href="route('register')"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-green-500 hover:text-white"
            >
                Register
            </Link>
        </template>

        <template v-else>
            <Dropdown align="right" width="48">
                <template #trigger>
                    <button
                        v-if="auth.user.profile_photo_url"
                        class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none"
                    >
                        <img
                            class="object-cover w-8 h-8 rounded-full"
                            :src="auth.user.profile_photo_url"
                            :alt="auth.user.name"
                        />
                    </button>
                </template>
                <template #content>
                    <DropdownLink :href="route('profile.show')"
                        >Profile</DropdownLink
                    >
                    <DropdownLink :href="route('dashboard')"
                        >Dashboard</DropdownLink
                    >
                    <div class="border-t border-gray-200" />
                    <form @submit.prevent="logout">
                        <DropdownLink as="button">Log Out</DropdownLink>
                    </form>
                </template>
            </Dropdown>
        </template>
    </div>
</template>
