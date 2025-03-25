<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from "vue";
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
        analyser.fftSize = 512; // Resolusi lebih tinggi
        dataArray = new Uint8Array(analyser.frequencyBinCount);

        // Hanya buat koneksi audio sekali
        if (!source) {
            source = audioCtx.createMediaElementSource(audioPlayer.value);
            source.connect(analyser);
            analyser.connect(audioCtx.destination);
        }
    }
    animateVisualizer();
};

// Animasi visualizer yang mengikuti progress
const animateVisualizer = () => {
    if (!ctx || !analyser || !canvas.value || !audioPlayer.value) return;
    requestAnimationFrame(animateVisualizer);
    
    analyser.getByteFrequencyData(dataArray);
    ctx.clearRect(0, 0, canvas.value.width, canvas.value.height);

    const width = canvas.value.width;
    const height = canvas.value.height;
    const barWidth = width / dataArray.length;

    dataArray.forEach((value, i) => {
        const barHeight = (value / 255) * height;
        ctx.fillStyle = `rgb(${value}, 100, 255)`;
        ctx.fillRect(i * barWidth, height - barHeight, barWidth - 1, barHeight);
    });

    // Progress indikator
    const progressX = (audioPlayer.value.currentTime / audioPlayer.value.duration) * width;
    ctx.fillStyle = "rgba(255, 255, 255, 0.8)";
    ctx.fillRect(progressX, 0, 3, height); // Garis putih sebagai indikator progress
};

// Fungsi untuk klik & drag progress bar (waveform)
const seek = (event) => {
    if (audioPlayer.value) {
        const rect = canvas.value.getBoundingClientRect();
        const clickPosition = event.clientX - rect.left;
        const newTime = (clickPosition / rect.width) * audioPlayer.value.duration;
        audioPlayer.value.currentTime = newTime;
    }
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
    <div class="flex flex-col items-center p-4">
        <!-- File Input -->
        <input type="file" @change="selectFile" accept="audio/*" class="mb-4" />
        <p class="text-gray-300">{{ fileName }}</p>

        <!-- Audio -->
        <audio ref="audioPlayer" :src="audioUrl" @timeupdate="updateProgress"></audio>

        <!-- Waveform -->
        <canvas ref="canvas" class="w-full h-20 bg-gray-900 rounded cursor-pointer mt-4" @click="seek"></canvas>

        <!-- Kontrol -->
        <div class="flex items-center gap-4 mt-4">
            <button @click="playMusic" v-if="!isPlaying">
                <Play size="32" class="text-green-500" />
            </button>
            <button @click="pauseMusic" v-else>
                <Pause size="32" class="text-red-500" />
            </button>
            <span class="text-white">{{ currentTime }} / {{ duration }}</span>
        </div>
    </div>
</template>