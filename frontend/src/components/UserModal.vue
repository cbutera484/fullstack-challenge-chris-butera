<template>
  <div class="modal-backdrop" @click.self="close">
    <div class="modal-content">
      <button class="modal-close" @click="close">&times;</button>
      <h2>Detailed Forecast</h2>
      <div v-if="user">
        <h2>{{ user.name }}</h2>
        <p class="description">{{ user.weather.description }}</p>
        <p class="temp">{{ user.weather.temp }}</p>
      </div>
      <div v-else>
        <p>No user data provided.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
  user: {
    type: Object,
    required: false,
    default: null,
  },
});

const emit = defineEmits(["close"]);

function close() {
  emit("close");
}
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}
.modal-content {
  background: #fff;
  padding: 2rem;
  border-radius: 8px;
  min-width: 320px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.2);
  position: relative;
}
.modal-close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: transparent;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}
</style>
