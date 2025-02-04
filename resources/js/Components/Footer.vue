<template>
    <footer class="p-4 text-center text-white bg-gray-800">
      <p>&copy; {{ currentYear }} Faisal Desk. All rights reserved.</p>
    </footer>
  </template>
  
  <script>
  export default {
    data() {
      return {
        currentYear: new Date().getFullYear(),
      };
    },
  };
  </script>
  