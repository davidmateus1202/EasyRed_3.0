<template>
    <div class="flex flex-col w-full h-full min-h-screen items-start justify-start bg-gray-50 overflow-x-hidden overflow-y-auto scroll-hidden">
        <!-- profile -->
         <div class="flex flex-col w-full h-auto items-center justify-center">
            <div class="relative w-full">
                <img src="https://wallpapers.com/images/hd/high-resolution-background-mpnoda7438yuowbk.jpg" class="h-70 w-full object-cover bg-top" alt="Profile Cover">
                <div class="absolute inset-0 bg-black/50 z-10"></div>
            </div>
            <div class="flex flex-col md:flex-row w-full h-auto -mt-20 md:ml-20 items-center gap-x-5 z-10">
                <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg" class="w-36 h-36 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out" alt="User Profile">
                <h1 class="text-xl md:text-2xl lg:text-4xl font-black md:-mt-10 md:text-white">David Mateus</h1>
            </div>
            <div class="hidden md:flex w-full h-24 -mt-20 bg-white items-center justify-center gap-x-10">
                <button class="text-gray-600">A m i g o s</button>
                <button class="text-gray-600">P u b l i c a c i o n e s</button>
                <button class="text-gray-600">F o t o s</button>
            </div>
         </div>

         <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 items-center justify-start w-full h-full scroll-hidden">
            <!-- Informacion personal -->
             <div class="flex flex-col w-full h-full p-5">
                <div class="flex flex-col w-full h-auto bg-white p-5 rounded-3xl">
                    <div class="flex items-center justify-start gap-x-3">
                        <i class="pi pi-globe text-gray-600"></i>
                        <h1 class="text-xl text-gray-600">Informacion</h1>
                    </div>
                    <div class="flex flex-col w-full h-auto mt-5">
                        <h1 class="text-gray-600 font-bold">Nombre</h1>
                        <span class="text-gray-400 font-light">David Mateus</span>
                    </div>

                    <div class="flex flex-col w-full h-auto mt-5">
                        <h1 class="text-gray-600 font-bold">Correo</h1>
                        <span class="text-gray-400 font-light">mateusdavid@gmail.com</span>
                    </div>

                    <div class="flex flex-col w-full h-auto mt-5">
                        <h1 class="text-gray-600 font-bold">Trabajo</h1>
                        <span class="text-gray-400 font-light">Desarrollador</span>
                    </div>
                </div>
             </div>

             <Post />


         </div>
    </div>
</template>

<script setup>
import Post from '../Components/Feed/Post.vue';

</script>