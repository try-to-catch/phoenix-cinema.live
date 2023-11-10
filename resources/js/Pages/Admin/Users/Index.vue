<script setup lang="ts">
import { computed, onMounted, ref, toRefs } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import PaginatedTable from '@/Components/Tables/PaginatedTable.vue'
import type { IPaginatedUserItems } from '@/types/users/IPaginatedUserItems'

const props = defineProps<{
  users: Readonly<IPaginatedUserItems>
}>()

const { users } = toRefs(props)

const formattedUsers = computed(() => {
  return users.value.data.map(user => {
    return {
      ...user,
      roles: user.roles.join(', '),
    }
  })
})

const searchInput = ref('')

const searchUsers = () => {
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
  <Head title="Фільми" />
  <AdminLayout :is-wide="true">
    <div class="py-12">
      <div class="container">
        <div class="space-y-6">
          <div class="p-4 sm:p-8 bg-tertiary border border-neutral-800 shadow sm:rounded-lg">
            <h2 class="text-lg font-medium text-white pb-4">Користувачі ({{ users.meta.total }})</h2>
            <PaginatedTable
              v-model:search-input="searchInput"
              :items="formattedUsers"
              route-item-key="id"
              edit-route-name="admin.users.edit"
              :pagination-meta-links="users.meta.links"
              @update:search-input="searchUsers"
            />
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped></style>
