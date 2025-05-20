<template>
  <div class="p-4 bg-white rounded-lg shadow">
    <h2 class="text-lg font-semibold mb-2">Mis Grupos</h2>

    <div v-if="loading" class="text-gray-500">Cargando...</div>
    <div v-else-if="error" class="text-red-500">{{ error }}</div>
    <div v-else-if="groups.length === 0" class="text-gray-500">No perteneces a ningún grupo todavía.</div>
    
    <ul v-else class="space-y-2">
      <li v-for="group in groups" :key="group.id">
        <router-link
          :to="{ name: 'GroupDetail', params: { slug: group.slug } }"
          class="block p-2 bg-gray-100 rounded hover:bg-gray-200 transition"
        >
          <div class="font-medium">{{ group.name }}</div>
          <div class="text-sm text-gray-600">{{ group.members_count }} miembros</div>
        </router-link>
      </li>
    </ul>

    <router-link
      to="/groups"
      class="mt-4 block text-center text-blue-600 hover:underline text-sm"
    >
      Ver todos los grupos
    </router-link>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const groups = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    const response = await api.get('/api/v1/groups?my_groups=true')
    groups.value = response.data
  } catch (err) {
    error.value = 'No se pudieron cargar los grupos.'
  } finally {
    loading.value = false
  }
})
</script>

<style scoped>
/* Opcional: estilos específicos */
</style>
