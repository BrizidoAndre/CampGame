<script setup>
import fullScreen from '@/assets/Images/fullscreen-mark.png';
import exitFullScreen from '@/assets/Images/lesscreen-mark.png';
import {ref} from "vue";

const props = defineProps(['bodyRef'])
const full = ref(false);

function changeScreen() {
    full.value = !full.value;
  if (props.bodyRef.fullscreenElement) {
    props.bodyRef.requestFullscreen();
  } else {
    document.exitFullscreen()
  }
}
</script>

<template>
  <button class="full-btn" @click="changeScreen">
    <img :src="full? exitFullScreen: fullScreen" alt="Pressione para mudar a visualização em tela cheia">
  </button>
</template>

<style scoped>

</style>
