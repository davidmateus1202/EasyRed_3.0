<template>
<div class="fixed inset-0 bg-black/50 z-20" @click="close">
    <div
        class="absolute bg-white shadow-lg rounded-3xl z-50 py-5"
        :style="{
            top: `${position.y}px`,
            left: `${position.x}px`,
        }"
        @click.stop
    >
        <div @click="getPosts('ASC')" class="flex w-auto items-center justify-between gap-x-16 mt-3 cursor-pointer px-5 py-2 hover:bg-gray-100">
            <h1 class="text-gray-600 text-xs">Antiguos</h1>
            <div class="flex w-8 h-8 items-center justify-center bg-gray-200 rounded-full">
                <i class="pi pi-angle-down"></i>
            </div>
        </div>
        <div @click="getPosts('DESC')" class="flex w-auto items-center justify-between gap-x-16 mt-3 cursor-pointer px-5 py-2 hover:bg-gray-100">
            <h1 class="text-gray-600 text-xs">Reciente</h1>
            <div class="flex w-8 h-8 items-center justify-center bg-gray-200 rounded-full">
                <i class="pi pi-angle-right"></i>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>

import { defineProps } from 'vue';
import { usePosStore } from '../Store/PosStore.js';

const post = usePosStore();
const props = defineProps({
    position: {
        type: Object,
        required: true,
    }
})

const emit = defineEmits(['close']);
const close = () => {
    emit('close');
}

const getPosts = async (value) => {
    post.order_by = value;
    await post.index(post.order_by);
    emit('close');
}

</script>