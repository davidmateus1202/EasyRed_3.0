<template>
    <div v-if="isLoading === false" class="flex flex-col w-full h-full items-start justify-start p-5 overflow-y-auto scroll-hidden">
        <div class="flex flex-col w-full h-auto bg-white rounded-3xl p-5">
            <div class="flex w-full h-auto items-start justify-start gap-5">
                <img src="https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg" class="w-10 h-10 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out" alt="User Profile">
                <div class="flex flex-col w-full h-auto">
                    <div class="flex w-full h-auto bg-gray-100 px-4 py-3 rounded-3xl items-center">
                        <input v-model="content" type="text" placeholder="Share something..." class="outline-none bg-gray-100 w-full h-auto placeholder:text-sm" />
                        <i class="pi pi-face-smile ml-2"></i>
                    </div>

                    <img v-if="imagePreview" :src="imagePreview" class="w-full h-60 rounded-3xl object-cover bg-top mt-5 transition duration-300 ease-in-out" alt="Preview Image" />
                    <!-- actions -->
                     <div class="flex w-full h-auto justify-between mt-2">
                        <input type="file" ref="fileRef" class="hidden" @change="handleFileChange" accept="image/*" />
                        <button @click="openFileDialog" class="flex items-center justify-center gap-3 cursor-pointer hover:bg-gray-100 p-3 rounded-3xl transition duration-300 ease-in-out">
                            <IconPhotoPlus stroke={1} />
                            <span class="font-bold text-gray-500">Image</span>
                        </button>

                        <div class="w-32">
                            <Button :onclick="create" :isLoading="isLoadingPost" />
                        </div>
                     </div>
                </div>
            </div>

        </div>

        <div class="flex w-full h-auto my-3 items-center justify-center gap-3 px-3">
            <div class="flex-1 h-0.5 bg-gray-300 shadow-2xl rounded-3xl"></div>
            <span class="text-gray-400 font-extralight">Sort by:</span>
            <button ref="filterButton" @click="toggleFilter" class="text-gray-600 font-bold cursor-pointer">{{ formatOrderBy(postStore.order_by) }}</button>
            <i class="pi pi-sort-down-fill" style="font-size: 0.7rem;"></i>
        </div>

        <!-- post -->
         <div v-for="(post, index) in postStore.posts" :key="index" class="flex flex-col w-full h-auto p-5 bg-white rounded-3xl mb-10">
            <div class="flex w-full justify-between">
                <div class="flex items-center gap-5">
                    <img 
                        :src="post.user?.photo !== null ? post.user?.photo : 'https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg'" 
                        class="w-10 h-10 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out" 
                        @error="handleImageError"
                        alt="User Profile">
                    <h3 class="text-gray-500 font-bold">{{ post.user?.name }}</h3>
                </div>
                <button class="hover:bg-gray-100 p-3 rounded-3xl transition duration-300 ease-in-out cursor-pointer">
                    <i class="pi pi-ellipsis-v" style="font-size: 0.8rem;"></i>
                </button>
            </div>
            <p v-if="post?.content !== 'null'" class="text-gray-600 mt-5">{{ post.content ?? '' }}</p>
            <img @error="post.image = null" v-if="post?.image !== null && post?.image !== '' && post?.image !== 'null'" :src="post?.image" class="w-full h-60 rounded-3xl object-cover bg-top mt-5" alt="Post Image">

            <!-- actions -->
            <div class="flex w-auto h-auto items-center justify-items-start px-3 mt-5 gap-5">
                <div class="flex items-center">
                    <i 
                    @click="toggleReaction(post?.id)"
                    :class="{
                        'pi pi-heart cursor-pointer': post?.user_reacted === false,
                        'pi pi-heart-fill text-red-500 cursor-pointer': post?.user_reacted === true
                    }"></i>
                    <span class="text-black font-bold ml-2">{{ post?.reaction_count }}</span>
                </div>

                <div class="flex items-center">
                    <i class="pi pi-comments"></i>
                    <span class="text-black font-bold ml-2">0</span>
                </div>
            </div>

            <!-- comments -->
            <div class="flex w-full h-auto items-center justify-center gap-3 mt-5">
                <img :src="user.user?.photo !== null ? user.user?.photo : 'https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg'" class="w-10 h-10 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out" alt="User Profile">
                <div class="flex w-full h-auto bg-gray-100 px-4 py-3 rounded-3xl items-center">
                    <input type="text" placeholder="Comment something..." class="outline-none bg-gray-100 w-full h-auto placeholder:text-sm" />
                    <i class="pi pi-send ml-2"></i>
                </div>
            </div>
         </div>
         <AlertError v-if="errorRequest" class="absolute top-0 left-0 right-0 mx-auto w-96" />
    </div>

    <div v-else class="flex w-full h-full items-center justify-center">
        <i class="pi pi-spin pi-spinner" style="font-size: 2rem"></i>
    </div>

    <!-- Dropdown or modals -->
     <FilterDropdown v-if="showFilter" @close="closeFilter" :position="position"/>


</template>

<script setup>

import { ref, onMounted, onUnmounted } from "vue";
import { usePosStore } from '../../Store/PosStore.js'
import { useUserStore } from '../../Store/UserStore.js'
import AlertError from '../Alerts/AlertError.vue'
import Button from '../Button.vue'
import FilterDropdown from "../FilterDropdown.vue";
import { IconPhotoPlus } from '@tabler/icons-vue';

const fileRef = ref(null);
const imagePreview = ref(null);
const content = ref(null);
const postStore = usePosStore();
const image = ref(null);
const errorRequest = ref(false);
const isLoading = ref(false);
const isLoadingPost = ref(false);
const user = useUserStore();
const showFilter = ref(false);
const position = ref({ x: 0, y: 0 });
const filterButton = ref(null);

onMounted(async () => {
    isLoading.value = true;
    await postStore.index(postStore.order_by);
    isLoading.value = false;

    window.addEventListener('resize', handleResize);
});

const openFileDialog = () => {
    fileRef.value.click();
};

const handleImageError = (e) => {
    e.target.src = 'https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg';
};

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (event) => {
            const img = new Image();
            img.onload = () => {
                // Establece las dimensiones máximas
                const MAX_WIDTH = 800;
                const MAX_HEIGHT = 800;
                let width = img.width;
                let height = img.height;

                // Calcular nuevas dimensiones manteniendo proporción
                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height = Math.round((height * MAX_WIDTH) / width);
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width = Math.round((width * MAX_HEIGHT) / height);
                        height = MAX_HEIGHT;
                    }
                }

                // Redibujar la imagen en un canvas
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                // Convertir a Blob para enviarla como archivo
                canvas.toBlob((blob) => {
                    image.value = new File([blob], file.name, { type: blob.type });
                    imagePreview.value = canvas.toDataURL(); // para previsualizar
                }, file.type, 0.9); // calidad opcional (0.0 a 1.0)
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
};


/**
 * create new post
 * @method createPost
 * @param {string} text - post text
 * @param {string} image - post image
 */
const create = async () => {
    isLoadingPost.value = true;

    if (image.value === null && content.value === null) {
        errorRequest.value = true;

        setTimeout(() => {
            errorRequest.value = false;
        }, 3000);
        isLoadingPost.value = false;
        return;
    }

    const formData = new FormData();
    formData.append("content", content.value);
    formData.append("image", image.value);

    const response = await postStore.createPost(formData);
    errorRequest.value = response;
    content.value = null;
    image.value = null;
    imagePreview.value = null;
    fileRef.value.value = null;

    setTimeout(() => {
        errorRequest.value = false;
    }, 3000)

    isLoadingPost.value = false;
}

/**
 * toggle reaction
 */
const toggleReaction = async (postId) => {
    await postStore.toggleReaction(postId);
}

/**
 * open filter dropdown
 */
const closeFilter = () => {
    showFilter.value = !showFilter.value;
}

const toggleFilter = async () => {
  if (filterButton.value) {
    const rect = filterButton.value.getBoundingClientRect();
    position.value = {
      x: rect.left + window.scrollX - 100,
      y: rect.bottom + window.scrollY + 10
    };
    showFilter.value = !showFilter.value;
  }
}

const handleResize = () => {
    if (showFilter.value) {
        showFilter.value = false;
    }
}

onUnmounted(() => {
    window.addEventListener('click', handleResize)
})

const formatOrderBy = (order) => {
    if (order === 'ASC') {
        return 'Antiguo';
    } else {
        return 'Reciente';
    }
}

</script>