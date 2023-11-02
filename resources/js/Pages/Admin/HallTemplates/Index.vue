<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { IPaginatedHallTemplateWithSeatCount } from '@/types/hallTemplates/IPaginatedHallTemplateWithSeatCount'
import { onMounted, ref, toRefs } from 'vue'
import PaginatedTable from '@/Components/Tables/PaginatedTable.vue'

const props = defineProps<{
  hallTemplates: Readonly<IPaginatedHallTemplateWithSeatCount>
}>()
const { hallTemplates } = toRefs(props)

const searchInput = ref('')

const searchTemplates = () => {
  const oldSearchInput = searchInput.value

  setTimeout(() => {
    if (searchInput.value === oldSearchInput) {
      router.reload({
        data: {
          s: oldSearchInput,
        },
      })
    }
  }, 1250)
}
onMounted(() => {
  const url = new URL(window.location.href)

  searchInput.value = url.searchParams.get('s') ?? ''
})
</script>

<template>
  <Head title="Шаблони залів" />
  <AdminLayout :is-wide="true">
    <div class="py-12">
      <div class="container">
        <div class="space-y-6">
          <div class="p-4 sm:p-8 bg-tertiary border border-neutral-800 shadow sm:rounded-lg">
            <h2 class="text-lg font-medium text-white pb-4">Шаблони залів ({{ hallTemplates.meta.total }})</h2>
            <PaginatedTable
              v-model:search-input="searchInput"
              :items="hallTemplates.data"
              route-item-key="id"
              edit-route-name="admin.hall_templates.edit"
              :pagination-meta-links="hallTemplates.meta.links"
              create-link-route-name="admin.hall_templates.create"
              @update:search-input="searchTemplates"
            />
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped></style>
