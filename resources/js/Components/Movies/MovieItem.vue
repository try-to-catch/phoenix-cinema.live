<script lang="ts" setup>
import {defineProps} from "vue";

defineProps<{ title: string, image_src: string }>()

</script>

<template>
    <li :title="title"
        class="min-w-[218px] w-full flex justify-center min-h-[322px] cursor-pointer relative">
        <div class="">
            <img :alt="`${title} poster`" :src="image_src">

            <div class="w-8 h-8 text-xs absolute rounded-md top-2 left-2 bg-white flex justify-center items-center">
                12+
            </div>
        </div>

    </li>
</template>
