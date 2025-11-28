<script setup>
const emits = defineEmits(['btnPress'])
</script>

<template>
  <div class="modal-background">
    <div class="modal">
      <h1 class="title">Seja bem-vindo!</h1>
      <button class="btn" @click="emits('btnPress')">Iniciar jornada</button>
    </div>
  </div>
</template>

<style scoped>
.modal {
  display: flex;
  flex-direction: column;
  gap: 3rem;
  align-items: center;
}


</style>
