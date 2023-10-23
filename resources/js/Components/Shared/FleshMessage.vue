<script lang="ts" setup>
import { onMounted, ref } from 'vue'

const { message } = defineProps<{ message?: string }>()

const isMessageVisible = ref(true)

onMounted(() => {
  setTimeout(() => (isMessageVisible.value = false), 3000)
})

const hiddeMessage = () => (isMessageVisible.value = false)
</script>

<template>
  <transition name="flash-message">
    <div
      v-if="isMessageVisible && message"
      class="absolute top-16 w-full flex justify-center z-10"
      @click="hiddeMessage"
    >
      <div
        class="min-w-[240px] hover:shadow hover:shadow-secondary duration-300 cursor-pointer bg-tertiary border border-secondary text-white py-2.5 px-4 rounded-lg text-center"
      >
        {{ message }}
      </div>
    </div>
  </transition>
</template>

<style scoped>
.flash-message-enter-active,
.flash-message-leave-active {
  transform: translateY(0);
  opacity: 1;
  transition: all 0.5s ease-in-out;
}

.flash-message-enter-from,
.flash-message-leave-to {
  transform: translateY(-25px);
  opacity: 0;
}
</style>
