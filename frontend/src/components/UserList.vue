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
  <UserModal
    v-if="isModalOpen"
    :user="selectedUser"
    @close="isModalOpen = false"
  />
</template>

<style scoped>
ul {
  max-width: 1200px;
  margin: 0 auto;
}
li {
  cursor: pointer;
}
</style>
