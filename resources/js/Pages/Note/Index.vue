<script setup>
import { Head } from "@inertiajs/vue3";
import { onMounted, ref, computed, watch } from "vue";
import EasyMDE from "easymde";
import "easymde/dist/easymde.min.css";
import { marked } from "marked";
// import GuestLayout from "@/Layouts/GuestLayout.vue"; // Jika ingin menggunakan layout

const markdownEditor = ref(null);
const previewContent = ref(""); // Hasil render Markdown
const previewPosition = ref("bottom"); // Default preview di bawah
let easyMDE;

/**
 * Setup EasyMDE Editor
 */
const setupEditor = () => {
    easyMDE = new EasyMDE({
        element: markdownEditor.value,
        spellChecker: false,
        autofocus: true,
        autosave: { enabled: true, uniqueId: "markdown-editor" },
        initialValue: localStorage.getItem("markdown-content") || "", // Ambil dari localStorage
        toolbar: [
            "bold", "italic", "heading", "|",
            "quote", "unordered-list", "ordered-list", "|",
            "link", "image", "preview", "side-by-side", "fullscreen", "|",
            "guide"
        ]
    });

    // Simpan ke localStorage saat ada perubahan
    easyMDE.codemirror.on("change", () => {
        const content = easyMDE.value();
        localStorage.setItem("markdown-content", content);
        previewContent.value = marked(content); // Render otomatis
    });

    // Render pertama kali
    previewContent.value = marked(easyMDE.value());
};

// Panggil setup saat mounted
onMounted(setupEditor);

/**
 * Simpan Markdown sebagai file .md
 */
const saveAsFile = () => {
    const content = easyMDE.value();
    const blob = new Blob([content], { type: "text/markdown" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "document.md";
    link.click();
};

// CSS dinamis untuk tata letak preview
const layoutClass = computed(() => {
    return previewPosition.value === "side"
        ? "flex space-x-6"  // Preview di samping
        : "flex flex-col space-y-6"; // Preview di bawah
});

// Update preview saat editor berubah
watch(previewPosition, () => {
    previewContent.value = marked(easyMDE.value());
});
</script>

<template>
    <Head title="FakeNote" />

    <!-- <GuestLayout> -->
    <div class="flex flex-col items-center justify-center min-h-screen bg-dots-darker dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="max-w-4xl mx-auto mt-10 mb-10 p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Markdown Editor</h2>

            <!-- Pilihan Tata Letak -->
            <div class="mt-4 flex items-center space-x-4">
                <label class="text-gray-600 dark:text-gray-300 font-medium">Posisi Preview:</label>
                <select v-model="previewPosition" class="p-2 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="bottom">Di Bawah</option>
                    <option value="side">Di Samping</option>
                </select>

                <button @click="saveAsFile"
                    class="px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600">
                    Simpan sebagai File
                </button>
            </div>

            <!-- Editor & Preview -->
            <div :class="layoutClass" class="mt-6">
                <!-- Markdown Editor -->
                <div class="w-full md:w-1/2">
                    <textarea ref="markdownEditor"></textarea>
                </div>

                <!-- Preview Markdown -->
                <div class="w-full md:w-1/2 p-4 border rounded-md bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200"
                    :class="{ 'mt-6': previewPosition === 'bottom' }">
                    <h3 class="text-lg font-medium">Preview:</h3>
                    <div v-html="previewContent" class="mt-2 prose dark:prose-invert"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- </GuestLayout> -->
</template>

<style>
/* Menyesuaikan tampilan EasyMDE */
.EasyMDEContainer {
    border-radius: 8px;
    overflow: hidden;
}
</style>
