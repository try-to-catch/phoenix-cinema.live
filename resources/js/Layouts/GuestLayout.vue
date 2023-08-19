<script setup lang="ts">
import {Link} from '@inertiajs/vue3';
import ApplicationLogoImage from "@/Components/Icons/ApplicationLogoImage.vue";
import ApplicationLogo from "@/Components/Icons/ApplicationLogo.vue";
</script>

<template>
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-primary">
    <div>
      <Link href="/" class="flex text-secondary items-center justify-center space-x-2">
        <ApplicationLogoImage class="h-8 fill-secondary bg-transparent text-gray-500"/>
        <ApplicationLogo :has-on-hover-animation="false" styles="fill-current text-gray-500"/>
      </Link>
    </div>

    <div
        class="w-full sm:max-w-md mt-6 px-6 py-5 bg-tertiary border border-neutral-800 shadow-md overflow-hidden sm:rounded-lg"
    >
      <slot/>
    </div>
  </div>
</template>
