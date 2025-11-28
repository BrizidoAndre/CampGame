<script setup>
import action from '@//assets/Images/x-mark.png';
const emits = defineEmits(['handlePress'])
</script>

<template>
  <button class="btn-close" @click="emits('handlePress')">
    <img :src="action" alt="Action button, press to toggle minigame">
  </button>
</template>

<style scoped>

</style>
