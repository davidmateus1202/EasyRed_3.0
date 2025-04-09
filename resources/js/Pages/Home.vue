<template>
    <div class="flex flex-col w-full h-screen bg-gray-100 overflow-hidden">
        <NavBar />
        <div class="grid grid-cols-3 w-full h-full items-center justify-center overflow-y-auto" 
        style="
        scrollbar-width: none;
        -ms-overflow-style: none; /* IE and Edge */
        &::-webkit-scrollbar {
            display: none;
        }">
            <!-- content profile -->
            <Profile />
            <!-- post -->
            <Post />
            <!-- friends -->
            <Friends />
        </div>
    </div>
</template>

<script setup>
// components
import NavBar from '../Components/NavBar.vue'
import Profile from '../Components/Feed/Profile.vue'
import Post from '../Components/Feed/Post.vue'
import Friends from '../Components/Feed/Friends.vue'

</script>