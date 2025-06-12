<script setup>
import { ref, onMounted } from "vue";
import UserCard from "@/components/UserCard.vue";
import UserModal from "@/components/UserModal.vue";
const users = ref(null);
const selectedUser = ref(null);
const isModalOpen = ref(false);

async function fetchData() {
  const url = "http://localhost/users";
  users.value = await (await fetch(url)).json();
}

onMounted(() => {
  fetchData();
});

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
