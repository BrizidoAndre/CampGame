<script setup>
import CloseButton from "@/components/CloseButton.vue";
import garrafa from "@/assets/Images/garrafa_com_filtro.jpg";
import medkit from "@/assets/Images/primeiros_socorros.jpg";
import canivete from "@/assets/Images/canivete_suico.jpg";
import {onMounted, onUnmounted, reactive, ref} from "vue";
import {storage} from "@/utils.js";

const emit = defineEmits(['btnPress', 'btnClose', 'win'])
const props = defineProps(['won'])
const itemsPure = [
  {
    img: garrafa,
    id: 1,
    turn: true,
  }, {
    img: garrafa,
    id: 1,
    turn: true,
  }, {
    img: medkit,
    id: 2,
    turn: true,
  }, {
    img: medkit,
    id: 2,
    turn: true,
  }, {
    img: canivete,
    id: 3,
    turn: true,
  }, {
    img: canivete,
    id: 3,
    turn: true,
  },
];
const cards = ref([]);
const firstSelected = ref(null);
const secondSelected = ref(null);
onMounted(() => {
  if (!props.won) {
    gameStart()
  }else{
    let cardsMemory = storage.get('memory', '[]');
    cards.value = [...cardsMemory];
  }
})

onUnmounted(()=>{
  if(props.won){
    storage.set('memory',cards.value);
  }
})

function gameStart() {
  let copyCards = [...itemsPure];
  copyCards.sort((a, b) => Math.random() - .5);
  cards.value = copyCards;
  setTimeout(() => {
    cards.value.forEach(card => {
      card.turn = false;
    })
  }, 3000)
}

function verifyCards() {
  let firstItem = cards.value[firstSelected.value];
  let secondItem = cards.value[secondSelected.value];
  const isRight = firstItem.id === secondItem.id;
  if (isRight) {
    cards.value[firstSelected.value].turn = true;
    cards.value[secondSelected.value].turn = true;
    firstSelected.value = null;
    secondSelected.value = null;
    verifyAll();
    return null;
  }
  setTimeout(() => {
    firstSelected.value = null;
    secondSelected.value = null;
  }, 3000)
}

function verifyAll() {
  let isDone = !cards.value.some(card => !card.turn)
  if (isDone) {
    emit('win');
  }
}

function handlePressCard(item, index) {
  if (item.turn) return null;
  if (firstSelected.value !== null && firstSelected.value !== index) {
    secondSelected.value = index;
    verifyCards();
  } else {
    firstSelected.value = index;
  }
}
</script>

<template>
  <div class="modal-background">
    <div class="modal">
      <CloseButton @handle-press="emit('btnClose')"/>
      <h2>Jogo da mochila (memória)</h2>
      <div class="grid-cards">
        <div
            v-for="(card, index) in cards"
            class="card-out"
            @click="handlePressCard(card, index)"
        >
          <div
              class="card-wrapper"
              :class="{
                'card-show': firstSelected === index || secondSelected === index || card.turn
              }"
          >
            <div class="side front"></div>
            <div class="side back">
              <img :src="card.img" alt="Imagem da carta da memória" class="card-img">
            </div>
          </div>
        </div>
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
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
}

.card-out {
  perspective: 1000px;
  height: 100px;
  cursor: pointer;
}

.card-wrapper {
  width: 100%;
  height: 100%;
  position: relative;
  transform-style: preserve-3d;
  transition: .4s;
}

.card-show {
  transform: rotateY(180deg);
}

.side {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  background: var(--brown);
  border-radius: 1rem;
  overflow: hidden;
}

.back {
  transform: rotateY(180deg);
  border-radius: 1rem;
}

.card-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

</style>
