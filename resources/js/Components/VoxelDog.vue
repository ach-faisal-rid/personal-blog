<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import * as THREE from "three";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";
import { DRACOLoader } from "three/examples/jsm/loaders/DRACOLoader.js";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls.js";

const containerRef = ref(null);
const loading = ref(true);

let scene, camera, renderer, controls;
let model;
let animationFrameId;

const init = () => {
    scene = new THREE.Scene();
    const width = containerRef.value.clientWidth;
    const height = containerRef.value.clientHeight;

    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(width, height);
    renderer.outputColorSpace = THREE.SRGBColorSpace;

    containerRef.value.appendChild(renderer.domElement);

    // Kamera dengan jarak yang lebih baik
    camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
    camera.position.set(0, 3, 5); // Geser kamera agar model terlihat

    // Tambahkan Pencahayaan
    const ambientLight = new THREE.AmbientLight(0xffffff, 1);
    const directionalLight = new THREE.DirectionalLight(0xffffff, 3);
    directionalLight.position.set(5, 5, 5);
    scene.add(ambientLight, directionalLight);

    // Orbit Controls
    controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.autoRotate = true;
    controls.autoRotateSpeed = 0.5;

    // Load Model dengan DRACOLoader
    const loader = new GLTFLoader();
    const dracoLoader = new DRACOLoader();
    dracoLoader.setDecoderPath("https://www.gstatic.com/draco/v1/decoders/");
    loader.setDRACOLoader(dracoLoader);

    loader.load(
        "/dog.glb",
        (gltf) => {
            model = gltf.scene;

            // **Perkecil skala model (dari ukuran besar ke ukuran kecil)**
            model.scale.set(0.8, 0.8, 0.8); // Sesuaikan jika masih terlalu besar/kecil

            // **Geser model ke atas agar tidak tenggelam**
            model.position.set(0, -1, 0);

            // **Putar model agar menghadap kamera dengan baik**
            model.rotation.y = Math.PI / 2;

            // Tambahkan model ke scene
            scene.add(model);

            // **Pastikan model memiliki material**
            model.traverse((child) => {
                if (child.isMesh && !child.material) {
                    child.material = new THREE.MeshStandardMaterial({ color: 0xffa500 });
                }
            });

            loading.value = false;
            animate();
        },
        (xhr) => {
            console.log(`Model Loading: ${(xhr.loaded / xhr.total) * 100}% loaded`);
        },
        (error) => console.error("Error loading model:", error)
    );
};

const animate = () => {
    animationFrameId = requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
};

// Resize handler
const handleResize = () => {
    if (!containerRef.value) return;
    const width = containerRef.value.clientWidth;
    const height = containerRef.value.clientHeight;
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height);
};

onMounted(() => {
    window.addEventListener("resize", handleResize);
    init();
});

onUnmounted(() => {
    window.removeEventListener("resize", handleResize);
    cancelAnimationFrame(animationFrameId);

    if (controls) controls.dispose();
    if (renderer) renderer.dispose();
    if (scene) scene.clear();
});
</script>

<template>
    <div ref="containerRef" class="relative w-full h-full overflow-hidden">
        <div v-if="loading" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <p class="text-white">Loading 3D Model...</p>
        </div>
    </div>
</template>

<style scoped>
div {
    width: 100%;
    height: 100%;
}
</style>
