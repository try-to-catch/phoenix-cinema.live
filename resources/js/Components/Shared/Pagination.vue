<script lang="ts" setup>
import {Link} from "@inertiajs/vue3";
import type {IPaginationMetaLink} from "@/types/shared/pagination/IPaginationMetaLink";

defineProps<{ links: IPaginationMetaLink[] }>()
</script>

<template>
  <ul v-if="links.length > 3" class="inline-flex text-sm space-x-px">
    <li v-for="(link, id) in links" :key="id">
        <span v-if="link.url === null"
              class="border border-neutral-700 flex items-center justify-center px-3 h-8 leading-tight bg-tertiary hover:bg-neutral-900 text-white cursor-not-allowed"
              v-html="link.label"/>

      <Link v-else
            :class="{
                    'text-white bg-secondary border-secondary': link.active,
                    'border-neutral-700  leading-tight text-white bg-tertiary hover:bg-neutral-900': !link.active
                       }"
            class="border flex items-center justify-center px-3 h-8"
            :href="link.url"

            v-html="link.label"
      />
    </li>
  </ul>
</template>


<style scoped>
ul > li:first-child > * {
  border-top-left-radius: 0.25rem;
  border-bottom-left-radius: 0.25rem;
}

ul > li:last-child > * {
  border-top-right-radius: 0.25rem;
  border-bottom-right-radius: 0.25rem;
}
</style>
