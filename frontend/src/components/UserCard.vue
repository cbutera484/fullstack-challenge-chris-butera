<template>
  <div class="user-card">
    <h2>{{ user.name }}</h2>
    <p>{{ user.weather.description }}</p>
    <p>{{ user.weather.temp }}</p>

    <p>
      <img
        :src="`https://openweathermap.org/img/wn/${user.weather.icon}@2x.png`"
      />
    </p>
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
  padding: 16px;
  margin: 8px 0;
  background: #fafafa;
}
</style>
