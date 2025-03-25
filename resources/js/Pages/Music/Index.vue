<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from "vue";
import { Head } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Play, Pause, Music } from "lucide-vue-next";

// Refs untuk elemen & data
const audioUrl = ref(null);
const audioPlayer = ref(null);
const fileName = ref("Belum ada file dipilih");
const progress = ref(0);
const isPlaying = ref(false);
const canvas = ref(null);
const currentTime = ref("0:00");
const duration = ref("0:00");
const isDragging = ref(false);
const seekBar = ref(null);

let ctx, analyser, dataArray;
let audioCtx = null;
let animationFrameId = null;
let source = null;

// Format waktu ke menit:detik
const formatTime = (time) => {
    if (isNaN(time) || time < 0) return "0:00";
    const minutes = Math.floor(time / 60);
    const seconds = Math.floor(time % 60);
    return `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
};

// Pilih file audio
const selectFile = (event) => {
    const file = event.target.files[0];
    if (file) {
        fileName.value = file.name;
        audioUrl.value = URL.createObjectURL(file);
        progress.value = 0;
        currentTime.value = "0:00";
        duration.value = "0:00";
    }
};

// Play musik
const playMusic = () => {
    if (!audioCtx) {
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
    if (audioCtx.state === "suspended") {
        audioCtx.resume();
    }
    audioPlayer.value?.play();
    isPlaying.value = true;
    updateProgress();
    setupVisualizer();
};

// Pause musik
const pauseMusic = () => {
    audioPlayer.value?.pause();
    isPlaying.value = false;
    cancelAnimationFrame(animationFrameId);
};

// Update progress bar & waktu dengan animasi
const updateProgress = () => {
    if (audioPlayer.value && audioPlayer.value.duration) {
        progress.value = (audioPlayer.value.currentTime / audioPlayer.value.duration) * 100;
        currentTime.value = formatTime(audioPlayer.value.currentTime);
        duration.value = formatTime(audioPlayer.value.duration);
        animationFrameId = requestAnimationFrame(updateProgress);
    }
};

// Setup Visualizer
const setupVisualizer = () => {
    if (!audioCtx || !canvas.value) return;
    if (!ctx) {
        ctx = canvas.value.getContext("2d");
    }
    if (!analyser) {
        analyser = audioCtx.createAnalyser();
        analyser.fftSize = 256;
        dataArray = new Uint8Array(analyser.frequencyBinCount);

        if (!source) {
            source = audioCtx.createMediaElementSource(audioPlayer.value);
            source.connect(analyser);
            analyser.connect(audioCtx.destination);
        }
    }
    animateVisualizer();
};

// Animasi visualizer
const animateVisualizer = () => {
    if (!ctx || !analyser || !canvas.value) return;
    requestAnimationFrame(animateVisualizer);
    analyser.getByteFrequencyData(dataArray);
    
    ctx.clearRect(0, 0, canvas.value.width, canvas.value.height);
    dataArray.forEach((value, i) => {
        const barHeight = (value / 255) * 100;
        ctx.fillStyle = `rgb(${value}, 100, 255)`;
        ctx.fillRect(i * 4, 100 - barHeight, 3, barHeight);
    });
};

// Seek functionality
const startSeek = (event) => {
    isDragging.value = true;
    updateSeek(event);

    window.addEventListener("mousemove", updateSeek);
    window.addEventListener("mouseup", stopSeek);
    window.addEventListener("touchmove", updateSeek, { passive: true });
    window.addEventListener("touchend", stopSeek);
};

const updateSeek = (event) => {
    if (!isDragging.value || !audioPlayer.value) return;

    const bar = seekBar.value;
    if (!bar) return;

    const rect = bar.getBoundingClientRect();
    const clientX = event.clientX || event.touches?.[0]?.clientX;
    const clickPosition = clientX - rect.left;
    const percentage = Math.min(Math.max(clickPosition / rect.width, 0), 1);

    if (!isNaN(audioPlayer.value.duration)) {
        audioPlayer.value.currentTime = percentage * audioPlayer.value.duration;
        progress.value = percentage * 100;
    }
};

const stopSeek = () => {
    isDragging.value = false;
    window.removeEventListener("mousemove", updateSeek);
    window.removeEventListener("mouseup", stopSeek);
    window.removeEventListener("touchmove", updateSeek);
    window.removeEventListener("touchend", stopSeek);
};

// Cleanup saat komponen di-unmount
onBeforeUnmount(() => {
    if (audioCtx) {
        audioCtx.close();
    }
    cancelAnimationFrame(animationFrameId);
});

onMounted(() => {
    if (canvas.value) {
        ctx = canvas.value.getContext("2d");
    }
});
</script>

<template>
    <Head title="🎼 Music Player" />

    <GuestLayout>
        <div class="flex flex-col items-center justify-center min-h-screen bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <h1 class="text-3xl font-bold mb-6 flex items-center gap-2">
                <Music class="w-7 h-7" /> Modern Music Player
            </h1>

            <div class="w-full max-w-md p-6 rounded-xl shadow-lg border border-gray-700 backdrop-blur-md">
                <p class="text-sm text-gray-400 mb-2">🎵 {{ fileName }}</p>

                <label class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition">
                    Pilih Audio
                    <input type="file" accept="audio/*" @change="selectFile" class="hidden" />
                </label>

                <canvas ref="canvas" width="200" height="100" class="mt-4 bg-gray-700 rounded"></canvas>

                <audio ref="audioPlayer" :src="audioUrl" class="hidden"></audio>

                <!-- Progress Bar (Dapat Diklik & Digeser) -->
                <div ref="seekBar" class="w-full bg-gray-700 h-2 rounded mt-4 cursor-pointer relative" 
                    @mousedown="startSeek" 
                    @touchstart="startSeek">
                    <div :style="{ width: progress + '%' }" class="bg-blue-500 h-2 rounded transition-all duration-200"></div>
                </div>

                <div class="flex justify-between text-sm text-gray-400 mt-2">
                    <span>{{ currentTime }}</span>
                    <span>{{ duration }}</span>
                </div>

                <div v-if="audioUrl" class="flex gap-4 mt-6 justify-center">
                    <button @click="playMusic" v-if="!isPlaying" class="p-3 bg-green-500 hover:bg-green-600 text-white rounded-full transition shadow-md">
                        <Play class="w-6 h-6" />
                    </button>
                    <button @click="pauseMusic" v-if="isPlaying" class="p-3 bg-red-500 hover:bg-red-600 text-white rounded-full transition shadow-md">
                        <Pause class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
