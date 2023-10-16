<script setup lang="ts">
import MagnifyingGlassIcon from '@/Components/Icons/MagnifyingGlassIcon.vue'
import { computed } from 'vue'
import type { ITableItem } from '@/types/tables/ITableItem'
import { Link } from '@inertiajs/vue3'
import type { IPaginationMetaLink } from '@/types/shared/pagination/IPaginationMetaLink'
import Pagination from '@/Components/Shared/Pagination.vue'
import PlusIcon from '@/Components/Icons/PlusIcon.vue'

const { items, paginationMetaLinks, routeName, routeItemKey, searchInput } = defineProps<{
  items: ITableItem[]
  paginationMetaLinks: IPaginationMetaLink
  routeName: string
  routeItemKey: keyof ITableItem
  createLinkRouteName?: string
  searchInput?: string
}>()

const emit = defineEmits<{
  'update:searchInput': [value: string]
}>()

const hasThumbnail = computed(() => {
  if (items.length === 0) return false
  return items[0]?.thumbnail !== undefined
})

const itemKeys = computed(() => {
  //exclude id and slug (if provided)
  return Object.keys(items[0]).filter(key => key !== 'id' && key !== 'slug' && key !== 'thumbnail')
})
</script>

<template>
  <div class="relative overflow-x-auto sm:rounded-lg flex flex-col">
    <div class="flex w-full items-center justify-between">
      <div v-if="searchInput !== undefined" class="pb-4 bg-tertiary">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1">
          <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <MagnifyingGlassIcon class="fill-neutral-400" />
          </div>
          <input
            id="table-search"
            :value="searchInput"
            type="text"
            class="block p-2 pl-10 text-sm text-white border border-neutral-800 rounded-lg w-80 bg-primary focus:ring-0 focus:border-secondary placeholder-neutral-300"
            placeholder="Search for items"
            @input="emit('update:searchInput', $event.target.value)"
          />
        </div>
      </div>

      <div v-if="createLinkRouteName">
        <Link
          :href="route(createLinkRouteName)"
          class="py-2 text-sm text-white border border-neutral-800 rounded-lg px-6 bg-primary text-center flex items-center justify-center hover:border-secondary duration-300"
        >
          Сворити
          <PlusIcon class="fill-current ml-2" />
        </Link>
      </div>
    </div>

    <table class="w-full text-sm text-left text-gray-500 bg-tertiary">
      <thead class="text-xs text-neutral-300 uppercase bg-primary border border-neutral-800">
        <tr>
          <th v-if="hasThumbnail" scope="col" class="px-6 py-3">Thumbnail</th>
          <th v-for="key in itemKeys" :key="key" scope="col" class="px-6 py-3">{{ key }}</th>
          <th scope="col" class="px-6 py-3">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in items"
          :key="item.id"
          class="bg-tertiary border-b border-b-neutral-800 text-white text-xs sm:text-base"
        >
          <td v-if="hasThumbnail" class="px-6 py-3">
            <div class="sm:h-28 h-20 sm:w-24 w-12">
              <img :src="item.thumbnail" :alt="`${item.id} thumbnail`" class="h-full w-full object-cover" />
            </div>
          </td>
          <td v-for="(key, index) in itemKeys" :key="index" class="px-6 py-4">{{ item[key] }}</td>
          <td class="px-6 py-4">
            <Link :href="route(routeName, item[routeItemKey])" class="font-medium text-secondary hover:underline"
              >Edit
            </Link>
          </td>
        </tr>
      </tbody>
    </table>

    <Pagination :links="paginationMetaLinks" class="mt-5 self-center" />
  </div>
</template>

<style scoped></style>
