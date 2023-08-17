<script setup lang="ts">

import ApplicationLogo from "@/Components/Icons/ApplicationLogo.vue";
import {Link} from "@inertiajs/vue3";
</script>

<template>
  <div class="font-sans-serif w-full min-h-screen flex flex-col bg-primary relative">
    <header class="fixed w-full z-20 sm:bg-primary bg-tertiary h-[50px] border-b border-neutral-700 sm:border-none">
      <div class="container py-2 flex items-center justify-between h-full">
        <div>
          <Link :href="route('home')">
            <ApplicationLogo/>
          </Link>
        </div>

        <div class="text-secondary space-x-2 flex text-sm md:text-base">
          <Link :href="route('login')">Вхід</Link>
          <div class="sm:block hidden">|</div>
          <Link :href="route('register')">Реєстрація</Link>
        </div>
      </div>

    </header>

    <main class="flex-grow mt-[50px]">
      <slot/>
    </main>

    <footer class="bg-tertiary w-full border-t border-neutral-800 text-center hidden sm:block">
      <div class="text-sm py-4 text-neutral-400">© 2022-2023 PX-Phoenix Holding. Всі права захищено</div>
    </footer>
  </div>
</template>

<style scoped>

</style>
