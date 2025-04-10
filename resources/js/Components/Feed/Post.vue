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
                            <i class="pi pi-images text-gray-500"></i>
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
            <span class="text-gray-600 font-bold">Recent</span>
            <i class="pi pi-sort-down-fill" style="font-size: 0.7rem;"></i>
        </div>

        <!-- post -->
         <div v-for="(post, index) in postStore.posts" :key="index" class="flex flex-col w-full h-auto p-5 bg-white rounded-3xl mb-10">
            <div class="flex w-full justify-between">
                <div class="flex items-center gap-5">
                    <img :src="post.user?.photo !== null ? post.user?.photo : 'https://i.pinimg.com/736x/d9/6f/ea/d96fea5c1a36aada8b18340f626383a1.jpg'" class="w-10 h-10 rounded-full border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition duration-300 ease-in-out" alt="User Profile">
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

</template>

<script setup>

import { ref, onMounted } from "vue";
import { usePosStore } from '../../Store/PosStore.js'
import { useUserStore } from '../../Store/UserStore.js'
import AlertError from '../Alerts/AlertError.vue'
import Button from '../Button.vue'

const fileRef = ref(null);
const imagePreview = ref(null);
const content = ref(null);
const postStore = usePosStore();
const image = ref(null);
const errorRequest = ref(false);
const isLoading = ref(false);
const isLoadingPost = ref(false);
const user = useUserStore();

onMounted(async () => {
    isLoading.value = true;
    await postStore.index();
    isLoading.value = false;
});

const openFileDialog = () => {
    fileRef.value.click();
};

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        image.value = file;
        const render = new FileReader();
        render.onload = () => {
            imagePreview.value = render.result;
        };

        render.readAsDataURL(file);
    }
}

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
 
</script>