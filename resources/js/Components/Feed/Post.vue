<template>
    <div class="flex flex-col w-full h-full items-start justify-start p-5">
        <div class="flex flex-col w-full h-auto bg-white rounded-3xl p-5">
            <div class="flex w-full h-auto items-start justify-start gap-5">
                <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg" class="w-10 h-10 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out" alt="User Profile">
                <div class="flex flex-col w-full h-auto">
                    <div class="flex w-full h-auto bg-gray-100 px-4 py-3 rounded-3xl items-center">
                        <input type="text" placeholder="Share something..." class="outline-none bg-gray-100 w-full h-auto" />
                        <i class="pi pi-face-smile ml-2"></i>
                    </div>

                    <!-- actions -->
                     <div class="flex w-full h-auto justify-between mt-2">
                        <button class="flex items-center justify-center gap-3 cursor-pointer hover:bg-gray-100 p-3 rounded-3xl transition duration-300 ease-in-out">
                            <i class="pi pi-images text-gray-500"></i>
                            <span class="font-bold text-gray-500">Image</span>
                        </button>

                        <button class="flex items-center justify-center gap-3 cursor-pointer hover:bg-gray-100 p-3 rounded-3xl transition duration-300 ease-in-out">
                            <i class="pi pi-globe text-gray-500"></i>
                            <span class="font-bold text-gray-500">Public</span>
                        </button>
                     </div>
                </div>
            </div>

        </div>

        <div class="flex w-full h-auto my-3 items-center justify-center gap-3 px-3">
            <div class="flex-1 h-0.5 bg-gray-300 shadow-2xl rounded-3xl"></div>
            <span class="text-gray-400 font-extralight">Sort by:</span>
            <span class="text-gray-600 font-bold">Recent</span>
            <i class="pi pi-sort-down-fill" style="font-size: 0.7rem;"></i>
        </div>

        <!-- post -->
         <div class="flex flex-col w-full h-auto p-5 bg-white rounded-3xl">
            <div class="flex w-full justify-between">
                <div class="flex items-center gap-5">
                    <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg" class="w-10 h-10 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out" alt="User Profile">
                    <h3 class="text-gray-500 font-bold">David Mateus Sosa</h3>
                </div>
                <button class="hover:bg-gray-100 p-3 rounded-3xl transition duration-300 ease-in-out">
                    <i class="pi pi-ellipsis-v" style="font-size: 0.8rem;"></i>
                </button>
            </div>
            <p>@trip EEUU I was triep</p>
            <img src="https://gaceta.cch.unam.mx/sites/default/files/styles/imagen_articulos_1920x1080/public/2023-09/pag_62.jpg?h=208bb47f&itok=Nj1QrlLd" alt="">
         </div>
    </div>
</template>