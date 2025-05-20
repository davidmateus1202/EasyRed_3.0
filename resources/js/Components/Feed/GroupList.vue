<template>
  <div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Todos los grupos</h1>

    <ul>
      <li
        v-for="group in groups"
        :key="group.id"
        class="mb-4 p-4 bg-white shadow rounded hover:bg-gray-100 transition-all"
      >
        <router-link
          :to="`/groups/${group.id}/posts`"
          class="text-lg font-semibold text-purple-700 hover:underline"
        >
          {{ group.name }}
        </router-link>
        <p class="text-gray-600">{{ group.description }}</p>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const groups = ref([]);

onMounted(async () => {
  try {
    const token = localStorage.getItem('token');
    const response = await axios.get('http://localhost:8000/api/v1/groups', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    groups.value = response.data.data ?? response.data;
  } catch (error) {
    console.error('Error al cargar grupos:', error);
  }
});
</script>
