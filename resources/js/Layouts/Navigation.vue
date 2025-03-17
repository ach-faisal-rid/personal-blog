<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import ApplicationMark from "../Components/ApplicationMark.vue";
import DesktopNav from "./DesktopNav.vue";
import MobileNav from "./MobileNav.vue";
import { useDarkMode } from "@/composables/useDarkMode";

const { isDark, toggleDarkMode } = useDarkMode();
const showingNavigationDropdown = ref(false);

const page = usePage();
const pageUrl = page.url;
</script>

<template>
    <div class="relative">
        <nav class="bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo / Home Link -->
                    <div class="flex items-center">
                        <Link :href="route('home')">
                            <ApplicationMark class="block w-auto h-9" />
                        </Link>
                    </div>

                    <!-- Center Navigation Menu About, Posts -->
                    <div class="flex items-center space-x-4">
                        <div class="flex space-x-6">
                            <Link
                                :href="route('home')"
                                :class="{
                                    'text-gray-600 dark:text-gray-300': true,
                                    'text-indigo-500 border-b-2 border-indigo-500':
                                        pageUrl.includes(route('home')),
                                    'hover:text-indigo-500 hover:border-indigo-500 transition-all duration-300': true,
                                }"
                                class="pb-1 border-b-2 border-transparent"
                            >
                                About
                            </Link>

                            <Link
                                :href="route('posts.index')"
                                :class="{
                                    'text-gray-600 dark:text-gray-300': true,
                                    'text-indigo-500 border-b-2 border-indigo-500':
                                        pageUrl.includes(route('posts.index')),
                                    'hover:text-indigo-500 hover:border-indigo-500 transition-all duration-300': true,
                                }"
                                class="pb-1 border-b-2 border-transparent"
                            >
                                Posts
                            </Link>
                            
                            <Link
                                :href="route('thumbnail.index')"
                                :class="{
                                    'text-gray-600 dark:text-gray-300': true,
                                    'text-indigo-500 border-b-2 border-indigo-500':
                                        pageUrl.includes(route('thumbnail.index')),
                                    'hover:text-indigo-500 hover:border-indigo-500 transition-all duration-300': true,
                                }"
                                class="pb-1 border-b-2 border-transparent"
                            >
                                thumbnails
                            </Link>

                        </div>
                    </div>

                    <!-- Right Navigation Section -->
                    <div class="flex items-center space-x-4">
                        <!-- Dark Mode Toggle -->
                        <button
                            @click="toggleDarkMode"
                            class="p-2 bg-gray-200 rounded-full dark:bg-gray-800"
                        >
                            <span v-if="isDark" class="text-white">🌞</span>
                            <span v-else class="text-gray-800">🌙</span>
                        </button>

                        <!-- Desktop Navigation menu -->
                        <div class="hidden md:block">
                            <DesktopNav />
                        </div>
                    </div>

                    <!-- Mobile Navigation Toggle -->
                    <div class="sm:hidden">
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                        >
                            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <MobileNav v-if="showingNavigationDropdown" />
        </nav>
    </div>
</template>
