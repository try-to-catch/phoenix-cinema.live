<script setup lang="ts">
import AngleDown from "@/Components/Icons/AngleDown.vue";
import DropdownLink from "@/Components/Breeze/DropdownLink.vue";
import Dropdown from "@/Components/Breeze/Dropdown.vue";

defineProps<{ userName: string, bgClass?: string }>()
</script>

<template>


  <Dropdown align="right" width="48">
    <template #trigger>
        <span class="inline-flex rounded-md">
            <button
                class="inline-flex items-center px-3 py-2 border border-transparent sm:text-base text-sm leading-4 font-medium rounded-md text-secondary hover:text-orange-600 focus:outline-none transition ease-in-out duration-300"
                type="button"
            >
                {{ userName }}
                <AngleDown/>
            </button>
        </span>
    </template>

    <template #content>
      <DropdownLink :href="route('profile.edit')">Профіль</DropdownLink>
      <DropdownLink :href="route('logout')" as="button" method="post">Вийти</DropdownLink>
    </template>
  </Dropdown>
</template>

<style scoped>

</style>
