import { ref, onMounted } from "vue";

export function useDarkMode() {
  // Mengambil nilai dari localStorage dan pastikan isDark selalu bernilai boolean
  const storedTheme = localStorage.getItem("theme");
  const isDark = ref(storedTheme === "dark");

  const toggleDarkMode = () => {
    // Menambahkan jeda waktu sebelum mengubah tema
    setTimeout(() => {
      isDark.value = !isDark.value;
      if (isDark.value) {
        document.documentElement.classList.add("dark");
        localStorage.setItem("theme", "dark");
      } else {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("theme", "light");
      }
    }, 300); // Jeda waktu 300ms
  };

  onMounted(() => {
    // Set tema default saat pertama kali dimuat
    if (localStorage.getItem("theme") === "dark") {
      document.documentElement.classList.add("dark");
      isDark.value = true;
    }
  });

  return { isDark, toggleDarkMode };
}
