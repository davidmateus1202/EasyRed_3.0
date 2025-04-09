<template>
    <div class="flex flex-col w-full h-full p-5 overflow-y-auto scroll-hidden">
        <div class="flex flex-col w-full h-auto bg-white p-5 rounded-3xl items-center">
            <img src="https://img.freepik.com/foto-gratis/diseno-collage-personas_23-2148888275.jpg" class="w-full h-60 rounded-3xl object-cover bg-top" alt="Profile Cover">
            <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg" class="w-36 h-36 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out -mt-24" alt="User Profile">
            <h1 class="mt-2 font-bold text-gray-600 text-lg">David Mateus Sosa</h1>
            <span class="text-gray-400 font-light">@david</span>

            <div class="grid grid-cols-3 w-full h-auto mt-5">
                <div class="flex flex-col items-center justify-center">
                    <h1 class="font-bold text-gray-600">0</h1>
                    <span class="text-gray-400 font-light">Publicaciones</span>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <h1 class="font-bold text-gray-600">0</h1>
                    <span class="text-gray-400 font-light">Seguidores</span>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <h1 class="font-bold text-gray-600">0</h1>
                    <span class="text-gray-400 font-light">Siguiendo</span>
                </div>
            </div>

            <div class="flex w-full h-auto mt-5">
                <Button />
            </div>

        </div>

        <!-- friends --> 
         <div class="flex flex-col w-full h-auto p-5 rounded-3xl items-start mt-5 bg-white">
            <h1 class="font-bold text-gray-600">Amigos</h1>
            <div class="flex w-full h-auto mt-5 gap-5 items-center justify-start">
                <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg" class="w-10 h-10 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out" alt="User Profile">
                <h3 class="text-gray-500">Paola Gonzalez</h3>
            </div>

            <div class="flex w-full h-auto mt-5 gap-5 items-center justify-start">
                <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg" class="w-10 h-10 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out" alt="User Profile">
                <h3 class="text-gray-500">Paola Gonzalez</h3>
            </div>

            <div class="flex w-full h-auto mt-5 gap-5 items-center justify-start">
                <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg" class="w-10 h-10 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out" alt="User Profile">
                <h3 class="text-gray-500">Paola Gonzalez</h3>
            </div>

            <div class="flex w-full h-auto mt-5 gap-5 items-center justify-start">
                <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg" class="w-10 h-10 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out" alt="User Profile">
                <h3 class="text-gray-500">Paola Gonzalez</h3>
            </div>
         </div>
    </div>
</template>

<script setup>

import Button from '../Button.vue'
</script>