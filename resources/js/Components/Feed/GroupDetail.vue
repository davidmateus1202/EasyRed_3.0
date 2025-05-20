<template>
  <div class="max-w-2xl mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4 text-center">Publicaciones del Grupo</h2>

    <!-- Formulario de nueva publicación -->
    <form @submit.prevent="submitPost" class="mb-6">
      <textarea
        v-model="newPost.content"
        placeholder="Escribe tu publicación..."
        class="w-full p-3 border border-gray-300 rounded resize-none focus:outline-none focus:ring-2 focus:ring-blue-400"
        rows="3"
      ></textarea>
      <button
        type="submit"
        class="bg-blue-500 text-white px-4 py-2 mt-2 rounded hover:bg-blue-600 transition"
      >
        Publicar
      </button>
    </form>

    <!-- Mensaje de carga -->
    <div v-if="loading" class="text-gray-500 text-center">Cargando publicaciones...</div>

    <!-- Lista de publicaciones -->
    <div v-else>
      <div v-if="posts.length > 0">
        <div
          v-for="post in posts"
          :key="post.id"
          class="mb-4 p-4 bg-white border rounded shadow hover:shadow-md transition"
        >
          <p class="text-gray-800">{{ post.content }}</p>
          <p class="text-sm text-gray-500 mt-2">
            Publicado por: {{ post.user?.name || 'Anónimo' }}
          </p>
        </div>
      </div>
      <div v-else class="text-gray-500 text-center">No hay publicaciones en este grupo.</div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

const route = useRoute();
const groupId = route.params.id; // 👈 este es el cambio importante

const posts = ref([]);
const newPost = ref({ content: '', type: 'text', media_url: null });
const loading = ref(false);

const fetchPosts = async () => {
  const token = localStorage.getItem('token');
  loading.value = true;
  try {
    const response = await axios.get(`http://localhost:8000/api/v1/groups/${groupId}/posts`, {
      headers: { Authorization: `Bearer ${token}` },
    });
    posts.value = response.data;
  } catch (error) {
    console.error('Error al cargar publicaciones:', error);
  } finally {
    loading.value = false;
  }
};

const submitPost = async () => {
  const token = localStorage.getItem('token');
  try {
    await axios.post(`http://localhost:8000/api/v1/groups/${groupId}/posts`, newPost.value, {
      headers: { Authorization: `Bearer ${token}` },
    });
    newPost.value.content = '';
    await fetchPosts(); // Recargar publicaciones
  } catch (error) {
    console.error('Error al guardar publicación:', error);
    alert('No se pudo guardar la publicación');
  }
};

onMounted(() => {
  fetchPosts();
});
</script>
