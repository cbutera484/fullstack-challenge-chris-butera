<script setup>
import { ref, onMounted } from "vue";
import UserCard from "@/components/UserCard.vue";
const apiResponse = ref(null);

async function fetchData() {
  const url = "http://localhost/users";
  apiResponse.value = await (await fetch(url)).json();
}

onMounted(() => {
  fetchData();
});
</script>

<template>
  <div v-if="!apiResponse">Loading Users...</div>

  <div v-if="apiResponse">
    <h1>Users</h1>
    <ul>
      <li v-for="user in apiResponse" :key="user.id">
        <UserCard :user="user" />
      </li>
      <li v-if="apiResponse.length === 0">No users found.</li>
    </ul>
  </div>
</template>
