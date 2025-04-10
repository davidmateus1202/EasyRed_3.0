<template>
    <button
      @click="props.onClick"
      class="w-full h-12 cursor-pointer bg-gradient-to-b from-indigo-500 to-indigo-600 shadow-[0px_4px_32px_0_rgba(99,102,241,.70)] px-6 py-3 rounded-3xl border-[1px] border-slate-500 text-white font-medium group"
    >
      <div class="relative overflow-hidden">
        <i v-if="props.isLoading === true" class="pi pi-spin pi-spinner" style="font-size: 1.5rem"></i>
        <p v-else class="text-sm group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
          Button
        </p>

        <p v-if="props.isLoading === false" class="w-full absolute text-sm top-7 left-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">Button</p>
      </div>
    </button>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  onClick: {
    type: Function,
    required: false,
    default: () => () => {} // Default to an empty function if not provided
  },
  isLoading: {
    type: Boolean,
    required: false,
    default: false
  },
})

</script>