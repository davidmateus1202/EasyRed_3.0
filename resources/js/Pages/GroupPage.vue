<template>
  <div
    v-if="visible"
    class="w-1/4 p-4 bg-gray-100 h-[calc(100vh-4rem)] overflow-y-auto border-l border-gray-300 fixed top-16 right-0 z-40"
  >
    <!-- Botón para cerrar el panel -->
    <button
      @click="visible = false"
      class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-xl"
      title="Cerrar"
    >
      ✖
    </button>

    <h2 class="text-xl font-bold mb-4">Grupos</h2>

    <!-- Formulario para crear nuevo grupo -->
    <form @submit.prevent="createGroup" class="mb-6 bg-white p-4 rounded-lg shadow">
      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700">Nombre del grupo</label>
        <input
          v-model="newGroup.name"
          type="text"
          required
          class="w-full mt-1 p-2 border rounded"
        />
      </div>
      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700">Descripción</label>
        <textarea
          v-model="newGroup.description"
          required
          class="w-full mt-1 p-2 border rounded"
        ></textarea>
      </div>
      <button
        type="submit"
        class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700"
      >
        Crear grupo
      </button>
    </form>

    <!-- Lista de grupos -->
    <ul>
      <li
        v-for="group in groups"
        :key="group.id"
        class="mb-3"
      >
        <router-link
          :to="`/groups/${group.id}`"
          class="block p-3 bg-white rounded-lg shadow hover:bg-purple-100 transition"
        >
          <h3 class="font-semibold text-gray-800">{{ group.name }}</h3>
          <p class="text-sm text-gray-500">{{ group.description }}</p>
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

// Estado de visibilidad del panel
const visible = ref(true)

// Lista de grupos y nuevo grupo
const groups = ref([])
const newGroup = ref({
  name: '',
  description: ''
})

// Cargar grupos desde el backend
const fetchGroups = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.get('http://localhost:8000/api/groups', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    groups.value = response.data
  } catch (error) {
    console.error('Error al cargar los grupos:', error)
  }
}

// Crear nuevo grupo
const createGroup = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.post(
      'http://localhost:8000/api/groups',
      newGroup.value,
      {
        headers: {
          Authorization: `Bearer ${token}`
        }
      }
    )
    groups.value.push(response.data)
    newGroup.value.name = ''
    newGroup.value.description = ''
  } catch (error) {
    console.error('Error al crear el grupo:', error)
  }
}

// Inicializar
onMounted(fetchGroups)
</script>
