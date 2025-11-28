<script setup>
import CloseButton from "@/components/CloseButton.vue";
import binoculos from '@/assets/Spare_Images/binoculos.png';
import bussola from '@/assets/Spare_Images/bussola.png';
import machado from '@/assets/Spare_Images/machado.png';
import lanterna from '@/assets/Spare_Images/lanterna.png';
import {computed, onMounted, onUnmounted, reactive, ref} from "vue";

const emit = defineEmits(['btnPress', 'btnClose', 'win'])
const props = defineProps(['won'])
const itemsPure = [
  {
    img: binoculos,
    title: 'Binóculos',
  }, {
    img: bussola,
    title: 'Bússola'
  }, {
    img: machado,
    title: 'Machado'
  }, {
    img: lanterna,
    title: 'Lanterna'
  },
]
const itemsGame = ref([])
const itemSelected = reactive({
  img: null,
  title: ''
});
onMounted(() => {
  if (!props.won) {
    gameStart()
  }
})

function getRandomInt(max) {
  return Math.floor(Math.random() * max);
}

function gameStart() {
  let items = [...itemsPure];
  items.sort((a, b) => Math.random() - .5);
  itemsGame.value = items;
  let selectedItem = items[getRandomInt(items.length)];
  itemSelected.img = selectedItem.img;
  itemSelected.title = selectedItem.title;
}

function pressImg(item) {
  if (itemSelected.title === item.title) {
    emit('win');
  } else {
    gameStart()
  }
}
</script>

<template>
  <div class="modal-background">
    <div class="modal">
      <CloseButton @handle-press="emit('btnClose')"/>
      <h2>Jogo da barraca (adivinhar)</h2>
      <p v-if="!props.won">Escolha o/a {{ itemSelected.title }}</p>
      <p v-else>Você ganhou!</p>
      <div class="grid-cards">
        <img
            class="card"
            :class="{
              'card-show': props.won,
            }"
            v-for="(item, index) in itemsGame"
            :src="item.img"
            alt="Coisa relacionada a acampamento"
            @click="pressImg(item)"
        >
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal {
  position: relative;
  display: flex;
  flex-direction: column;
  gap: 3rem;
  align-items: flex-start;
  min-width: 50vw;

}

h2 {
  font-size: 1rem;
}

.grid-cards {
  width: 100%;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}

.card {
  width: 100px;
  object-fit: cover;
  filter: brightness(0);
}

.card-show {
  filter: brightness(1);
}

</style>
