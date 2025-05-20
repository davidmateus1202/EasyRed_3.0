<template>
  <div class="flex flex-col w-full h-screen bg-gray-100 overflow-hidden">
    <NavBar />
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full h-full items-start gap-4 p-4 overflow-y-auto" 
         style="scrollbar-width: none; -ms-overflow-style: none;">
      <!-- Sección de perfil -->
      <Profile />

      <!-- Sección de publicaciones -->
      <Post />

      <!-- Sección de amigos -->
      <Friends />

      <!-- Sección de grupos -->
      <GroupPage />
    </div>
  </div>
</template>

<script setup>
// Componentes principales
import NavBar from '../Components/NavBar.vue'
import Profile from '../Components/Feed/Profile.vue'
import Post from '../Components/Feed/Post.vue'
import Friends from '../Components/Feed/Friends.vue'

// Componente de grupos
import GroupPage from '../Pages/GroupPage.vue'
</script>
