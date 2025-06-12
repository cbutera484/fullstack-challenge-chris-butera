<template>
  <div class="user-card">
    <h2>{{ user.name }}</h2>
    <p class="icon">
      <img
        :src="`https://openweathermap.org/img/wn/${user.weather.icon}@2x.png`"
        alt="Weather Icon"
      />
    </p>

    <p class="temp">{{ Math.round(user.weather.temp) }}&#8457;</p>
    <p class="description">{{ user.weather.description }}</p>
  </div>
</template>

<script setup>
defineProps({
  user: {
    type: Object,
    required: true,
  },
});
</script>

<style scoped>
.user-card {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 0 2rem;
  margin: 8px 0;
  background: #fafafa;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  display: block;
}

.user-card:hover {
  background: #f0f0f0;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

h2,
p {
  width: 100%;
  text-align: center;
}

@media (min-width: 767px) {
  .user-card {
    display: flex;
    text-align: center;
  }
  h2,
  p {
    width: 25%;
    padding: 0 1rem;
  }
}

/* normally I would set these as a configurable mixin for different devices for a larger app */
</style>
