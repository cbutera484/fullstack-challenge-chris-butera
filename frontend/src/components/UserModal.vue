<template>
  <div class="modal-backdrop" @click.self="close">
    <div class="modal-content">
      <button class="modal-close" @click="close">&times;</button
      ><!--Todo add
      close on escape key-->
      <p class="icon">
        <img
          :src="`https://openweathermap.org/img/wn/${user.weather.icon}@2x.png`"
        />
      </p>

      <div v-if="user">
        <h2>{{ user.name }}</h2>
        <p class="temp">
          <strong>Temperature:</strong>
          {{ Math.round(user.weather.temp) }}&#8457;
        </p>
        <p class="" feels-like>
          <strong>Feels Like:</strong>
          {{ Math.round(user.weather.feels_like) }}&#8457;
        </p>
        <p class="low">
          <strong>Low:</strong> {{ Math.round(user.weather.temp_min) }}&#8457;
        </p>
        <p class="high">
          <strong>High:</strong> {{ Math.round(user.weather.temp_max) }}&#8457;
        </p>
        <p class="description">
          <strong>Description:</strong> {{ user.weather.description }}
        </p>
        <p class="humidity">
          <strong>Humidity:</strong> {{ user.weather.humidity }}%
        </p>
        <p class="wind">
          <strong>Wind Speed:</strong> {{ user.weather.wind_speed }} mph
        </p>
        <p class="pressure">
          <strong>Pressure:</strong> {{ user.weather.pressure }} hPa
        </p>
      </div>
      <div v-else>
        <p>No user data provided.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

defineProps({
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
  padding: 4rem;
  border-radius: 8px;
  min-width: 320px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.2);
  position: relative;
  width: 90%;
  max-width: 600px;
  box-sizing: border-box;
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
p.icon {
  text-align: center;
  margin: 0 auto;
}
</style>
