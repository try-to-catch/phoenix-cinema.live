<script lang="ts" setup>
import ApplicationLogo from '@/Components/Icons/ApplicationLogo.vue'
import { Link } from '@inertiajs/vue3'
import DefaultDropdown from '@/Layouts/Shared/DefaultDropdown.vue'
import { computed, onMounted, onUnmounted, ref } from 'vue'

const pagesWithLongHeader = ['home', 'movies.index']

const isHeaderLong = computed(() => {
  return pagesWithLongHeader.includes(route().current()!)
})

const scrollTop = ref(0)

const updateScrollY = () => {
  scrollTop.value = window.scrollY
}

onMounted(() => {
  window.addEventListener('scroll', updateScrollY)
})

onUnmounted(() => {
  window.removeEventListener('scroll', updateScrollY)
})

const isHeaderFixed = computed(() => {
  return scrollTop.value > 50
})
</script>

<template>
  <div class="font-sans-serif w-full min-h-screen flex flex-col bg-primary relative">
    <header
      :class="{
        'bg-tertiary shadow': isHeaderFixed,
        'sm:bg-primary bg-tertiary': !isHeaderFixed,
      }"
      class="fixed w-full z-20 h-[50px] border-b border-neutral-800 sm:border-none duration-300 ease-in-out"
    >
      <div
        :class="{ container: isHeaderLong, 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8': !isHeaderLong }"
        class="py-2 flex items-center justify-between h-full"
      >
        <div>
          <Link :href="route('home')">
            <ApplicationLogo />
          </Link>
        </div>

        <div v-if="!$page.props.auth.user" class="text-secondary space-x-2 flex text-sm md:text-base">
          <Link :href="route('login')"> Вхід </Link>
          <div class="sm:block hidden">|</div>
          <Link :href="route('register')"> Реєстрація </Link>
        </div>

        <div v-if="$page.props.auth.user" class="ml-3 relative">
          <DefaultDropdown :user-name="$page.props.auth.user.name" />
        </div>
      </div>
    </header>

    <main class="flex-grow pt-[50px]">
      <slot />
    </main>

    <footer class="bg-tertiary w-full border-t border-neutral-800 text-center hidden sm:block">
      <div class="text-sm py-4 text-neutral-400">© 2022-2023 PX-Phoenix Holding. Всі права захищено</div>
    </footer>
  </div>
</template>

<style scoped></style>
