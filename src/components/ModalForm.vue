<script setup>
const emits = defineEmits(['btnPress'])
const props = defineProps(['time'])
</script>

<template>
  <div class="modal-background">
    <div class="modal">
      <form action="">
        <h2>{{ props.time }} segundos</h2>
        <div class="row">
          <div>
            <label for="nome">Nome</label>
            <input type="text" id="nome" placeholder="Nome e sobrenome">
          </div>
          <div>
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="xxxxx@xxxx.com">
          </div>
        </div>
        <div class="row">
          <div>
            <label for="idade">Idade</label>
            <input type="number" id="idade" placeholder="XX">
          </div>
          <div>
            <label for="phone">Telefone</label>
            <input type="text" id="phone" placeholder="(xx) xxxx-xxxx">
          </div>
        </div>
        <div class="sugestoes">
          <label for="sugestoes">Sugestões</label>
          <input type="text" id="sugestoes">
        </div>
        <input type="submit" class="btn" value="ENVIAR">
      </form>
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

.row {
  display: flex;
  gap: 1rem;
}

.row > div {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.sugestoes{
  margin-top: 1rem;
  display: flex;
  flex-direction: column;
}

input{
  border-radius: 1rem;
  background: white;
  border:none;
  padding: 1rem;
}
input[type=submit]{
  background: var(--brown-light);
  width: 100%;
  margin-top: 1rem;
  border:1px solid black;
}
</style>
