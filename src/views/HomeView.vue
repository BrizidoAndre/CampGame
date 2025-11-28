<script setup>
import ModalStart from "@/components/ModalStart.vue";
import char from '@/assets/Images/personagem-sprites.png'
import {onMounted, onUnmounted, reactive, ref, useTemplateRef} from "vue";
import FullScreen from "@/components/FullScreen.vue";
import ActionButton from "@/components/ActionButton.vue";
import ModalFire from "@/components/ModalFire.vue";
import ModalBarrack from "@/components/ModalBarrack.vue";
import ModalBackpack from "@/components/ModalBackpack.vue";
import ModalForm from "@/components/ModalForm.vue";

const mainRef = useTemplateRef('mainRef');
const modalShow = ref('start');
const modalAnimation = ref('none');
const gameInfo = reactive({
  gameStart: true,
  gameCharRight: true,
  xPosition: 45,
  fireGame: false,
  barrackGame: false,
  backpackGame: false,
  doAction: true,
  time: 0,
  timeIntervalId: null,
})
const charPosition = ref(100);
let charMove = false;
const charDistance = 0.4;

function handleModal(text) {
  if (!gameInfo.doAction) return null;
  modalAnimation.value = text;
  setTimeout(() => {
    modalShow.value = text;
    gameInfo.gameStart = true;
  }, 1000)
}

function moveChar(ev) {
  let key = ev.key;
  let isLeftDirection = key === 'ArrowLeft';
  let isRightDirection = key === 'ArrowRight';
  if (isLeftDirection) {
    gameInfo.gameCharRight = false;
    gameInfo.xPosition -= charDistance;
    charMove = true;
  } else if (isRightDirection) {
    gameInfo.gameCharRight = true;
    gameInfo.xPosition += charDistance;
    charMove = true;
  }
}

function addEvents() {
  window.addEventListener('keydown', moveChar)
  window.addEventListener('keyup', () => {
    charMove = false;
  })
  setInterval(() => {
    if (charMove) {
      charPosition.value = (charPosition.value - 20 + 100) % 100;
    }
  }, 100)
}

function removeEvents() {
  window.removeEventListener('keydown', moveChar)
}

onMounted(() => {
  addEvents()
  gameInfo.timeIntervalId = setInterval(() => {
    gameInfo.time++;
  }, 1000)
})
onUnmounted(() => {
  removeEvents()
})

function fireWon() {
  gameInfo.fireGame = true;
  allWon()
}

function barrackWon() {
  gameInfo.barrackGame = true;
  allWon()
}

function backpackWon() {
  gameInfo.backpackGame = true;
  allWon()
}

function allWon() {
  clearInterval(gameInfo.timeIntervalId);
  let allWon = gameInfo.barrackGame && gameInfo.backpackGame && gameInfo.fireGame;
  if (!allWon) return null;
  setTimeout(() => {
    removeEvents();
    handleModal('');
    gameInfo.doAction = false;
    gameInfo.gameCharRight = false;
    charMove = true;
    let intervalId = setInterval(() => {
      if (gameInfo.xPosition <= -50) {
        clearInterval(intervalId);
        modalAnimation.value = 'form';
        setTimeout(() => {
          modalShow.value = 'form';
          gameInfo.gameStart = true;
        }, 1000)
      }
      gameInfo.xPosition -= .2;
    }, 10)
  }, 700)

}
</script>

<template>
  <main ref="mainRef">
    <FullScreen :body-ref="mainRef"/>
    <!--    action buttons -->
    <ActionButton
        @handle-press="handleModal('backpack')"
        :style="{
           top: '60%',
           left: '77%'
        }"
    />
    <ActionButton
        @handle-press="handleModal('barrack')"
        :style="{
           top: '38%',
           left: '63%'
        }"
    />
    <ActionButton
        @handle-press="handleModal('fire')"
        :style="{
           top: '50%',
           left: '24%'
        }"
    />
    <!--    modals -->
    <ModalStart
        @btn-press="handleModal('')" v-if="modalShow === 'start'"
        :class="{
          'fade-out': modalAnimation === ''
        }"
    />
    <ModalFire
        v-if="modalShow === 'fire'"
        @btn-close="handleModal('')"
        :class="{
          'fade-out': modalAnimation === ''
        }"
        @win="fireWon()"
        :won="gameInfo.fireGame"
    />
    <ModalBarrack
        v-if="modalShow === 'barrack'"
        @btn-close="handleModal('')"
        :class="{
          'fade-out': modalAnimation === ''
        }"
        @win="barrackWon()"
        :won="gameInfo.barrackGame"
    />
    <ModalBackpack
        v-if="modalShow === 'backpack'"
        @btn-close="handleModal('')"
        :class="{
          'fade-out': modalAnimation === ''
        }"
        @win="backpackWon()"
        :won="gameInfo.backpackGame"
    />
    <ModalForm
        v-if="modalShow === 'form'"
        :time="gameInfo.time"
    />
    <img
        class="character"
        :class="{
        'show-char': gameInfo.gameStart,
        'face-left': !gameInfo.gameCharRight
      }"
        :style="{
        left: gameInfo.xPosition + '%',
        objectPosition: charPosition + '%'
      }"
        :src="char"
        alt="Personangem principal do jogo">
  </main>
</template>
