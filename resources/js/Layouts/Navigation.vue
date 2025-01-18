<script setup>
import { ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue'; // nggak dipakai
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

const page = usePage();
const auth = page.props.auth ?? {}; // Prevent errors if auth is undefined

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'), {}, {
        onSuccess: () => {
            page.props.auth.user = null; // Hapus user manual
            router.visit(route('home'), { replace: true }); // Paksa redirect ke home
        }
    });
};

const canRegister = true; // Adjust logic if needed for the register option
</script>

<template>
    <div class="relative">
        <nav class="bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex items-center shrink-0">
                            <Link :href="route('home')">
                            <ApplicationMark class="block w-auto h-9" />
                            </Link>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <div class="relative ms-3">
                            <!-- Tampilkan Login dan Register jika user belum login -->
                            <span v-if="!auth?.user" class="inline-flex space-x-4">
                                <Link :href="route('login')"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-200 ease-in-out bg-white border border-gray-300 rounded-md hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:bg-blue-600">
                                Login
                                </Link>
                                <Link :href="route('register')"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-200 ease-in-out bg-white border border-gray-300 rounded-md hover:bg-green-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 active:bg-green-600">
                                Register
                                </Link>
                            </span>
                            <!-- Tampilkan Dropdown jika user sudah login -->
                            <Dropdown v-if="auth?.user" align="right" width="48">
                                <template #trigger>
                                    <button v-if="auth?.user && auth?.user.profile_photo_url"
                                        class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                        <img class="object-cover w-8 h-8 rounded-full"
                                            :src="auth.user.profile_photo_url" :alt="auth.user.name">
                                    </button>
                                </template>

                                <template #content>
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>
                                    
                                    <DropdownLink v-if="auth?.user" :href="route('dashboard')">
                                        Dashboard
                                    </DropdownLink>

                                    <DropdownLink v-if="auth?.user" :href="route('profile.show')">
                                        Profile
                                    </DropdownLink>

                                    <DropdownLink v-if="auth?.user && $page.props.jetstream.hasApiFeatures"
                                        :href="route('api-tokens.index')">
                                        API Tokens
                                    </DropdownLink>

                                    <div class="border-t border-gray-200" />

                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Log Out
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>

                        </div>
                    </div>
                </div>
            </div>

            <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
                class="sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink v-if="auth?.user" :href="route('profile.show')"
                        :active="route().current('profile.show')">
                        Profile
                    </ResponsiveNavLink>

                    <ResponsiveNavLink v-if="auth?.user && $page.props.jetstream.hasApiFeatures"
                        :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                        API Tokens
                    </ResponsiveNavLink>

                    <form @submit.prevent="logout">
                        <ResponsiveNavLink as="button">
                            Log Out
                        </ResponsiveNavLink>
                    </form>

                    <ResponsiveNavLink v-if="!auth?.user" :href="route('login')"
                        class="text-gray-500 dark:text-gray-300">
                        Login
                    </ResponsiveNavLink>

                    <ResponsiveNavLink v-if="canRegister && !auth?.user" :href="route('register')"
                        class="text-gray-500 dark:text-gray-300">
                        Register
                    </ResponsiveNavLink>
                </div>
            </div>
        </nav>
    </div>
</template>
