// stores/postStore.js
import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';

export const usePostStore = defineStore('postStore', () => {
  const posts = ref([]);

  async function index(groupId) {
    try {
      const res = await axios.get(`/api/groups/${groupId}/posts`);
      posts.value = res.data;
    } catch (error) {
      console.error('Error al obtener los posts:', error);
    }
  }

  return {
    posts,
    index,
  };
});
