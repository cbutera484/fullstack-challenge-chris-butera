<script setup>
import { ref, onMounted } from "vue";
import UserCard from "@/components/UserCard.vue";
import UserModal from "@/components/UserModal.vue";
const users = ref(null);
const selectedUser = ref(null);
const isModalOpen = ref(false);

onMounted(() => {
  fetchData();
});
const error = ref(null);

async function fetchData() {
  const url = "http://localhost/users";
  error.value = null;
  try {
    const controller = new AbortController();
    const timeout = setTimeout(() => controller.abort(), 5000); // 5s timeout
    const response = await fetch(url, { signal: controller.signal });
    clearTimeout(timeout);
    if (!response.ok) {
      throw new Error(`Error: ${response.status}`);
    }
    users.value = await response.json();
  } catch (err) {
    users.value = [];
    error.value = err.message || "Failed to fetch users.";
  }
}
function openModal(user) {
  selectedUser.value = user;
  isModalOpen.value = true;
}
</script>

<template>
  <div v-if="!users">Loading Users...</div>

  <div v-if="users">
    <ul>
      <li v-for="user in users" :key="user.id">
        <UserCard :user="user" @click="openModal(user)" />
      </li>
      <li v-if="users.length === 0">No users found.</li>
      <li class="error" v-if="error">
        Error: {{ error }}. Please refresh or try again later
      </li>
    </ul>
  </div>
  <transition name="fade">
    <UserModal
      v-if="isModalOpen"
      :user="selectedUser"
      @close="isModalOpen = false"
    />
  </transition>
</template>

<style scoped>
ul {
  max-width: 1200px;
  margin: 0 auto;
}
li.error {
  color: red;
  text-align: center;
  font-weight: bold;
}

/* Todo: make fade animation a little more fancy */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease-in-out;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
