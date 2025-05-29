<script setup>
import { Head } from "@inertiajs/vue3";
import { onMounted, ref, computed, watch, nextTick } from "vue";
import EasyMDE from "easymde";
import "easymde/dist/easymde.min.css";
import { marked } from "marked";

const markdownEditor = ref(null);
const previewContent = ref("");
const previewPosition = ref("bottom");
let easyMDE;

const setupEditor = () => {
    easyMDE = new EasyMDE({
        element: markdownEditor.value,
        spellChecker: false,
        autofocus: true,
        autosave: { enabled: true, uniqueId: "markdown-editor" },
        initialValue: localStorage.getItem("markdown-content") || "",
        toolbar: [
            "bold", "italic", "heading", "|",
            "quote", "unordered-list", "ordered-list", "|",
            "link", "image", "preview", "side-by-side", "fullscreen", "|",
            "guide"
        ]
    });

    // Sync content on change
    easyMDE.codemirror.on("change", () => {
        const content = easyMDE.value();
        localStorage.setItem("markdown-content", content);
        previewContent.value = marked(content);
    });

    previewContent.value = marked(easyMDE.value());
};

onMounted(setupEditor);

// Save as file
const saveAsFile = () => {
    const content = easyMDE.value();
    const blob = new Blob([content], { type: "text/markdown" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "document.md";
    link.click();
};

// Import file
const importFile = async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (e) => {
        easyMDE.value(e.target.result);
        localStorage.setItem("markdown-content", e.target.result);
        previewContent.value = marked(e.target.result);
    };
    reader.readAsText(file);
};

// Dynamic layout
const layoutClass = computed(() => {
    return previewPosition.value === "side"
        ? "flex flex-col md:flex-row md:space-x-6"
        : "flex flex-col space-y-6";
});

// Refresh editor layout when position changes
watch(previewPosition, async () => {
    previewContent.value = marked(easyMDE.value());
    await nextTick();
    easyMDE.codemirror.refresh(); // Fix for visual glitch
});
</script>

<template>
    <Head title="FakeNote" />

    <div class="flex flex-col items-center justify-center min-h-screen bg-dots-darker dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="max-w-4xl w-full mx-auto mt-10 mb-10 p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Markdown Editor</h2>

            <div class="mt-3 flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2">
                    <label class="text-gray-600 dark:text-gray-300 font-medium">Posisi Preview:</label>
                    <select v-model="previewPosition"
                        class="p-2 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="bottom">Di Bawah</option>
                        <option value="side">Di Samping</option>
                    </select>
                </div>

                <div class="mt-4 flex space-x-2">
                    <input type="file" accept=".md" @change="importFile" class="hidden" id="fileInput">
                    <label for="fileInput"
                        class="px-4 py-2 bg-purple-500 text-white font-semibold rounded-lg hover:bg-purple-600 cursor-pointer">
                        Import File
                    </label>

                    <button @click="saveAsFile"
                        class="px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600">
                        Simpan sebagai File
                    </button>
                </div>
            </div>

            <!-- Editor & Preview -->
            <div :class="layoutClass + ' mt-6'">
                <!-- Markdown Editor -->
                <div :class="previewPosition === 'side' ? 'w-full md:w-1/2' : 'w-full'">
                    <textarea ref="markdownEditor"></textarea>
                </div>

                <!-- Preview -->
                <div :class="[
                        previewPosition === 'side' ? 'w-full md:w-1/2' : 'w-full mt-6',
                        'p-4 border rounded-md bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200'
                    ]">
                    <h3 class="text-lg font-medium">Preview:</h3>
                    <div v-html="previewContent" class="mt-2 prose dark:prose-invert max-w-none"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.EasyMDEContainer {
    border-radius: 8px;
    overflow: hidden;
}
</style>
