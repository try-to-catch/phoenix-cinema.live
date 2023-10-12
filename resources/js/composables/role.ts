import { computed } from 'vue'
import { RoleName } from '@/types/roles/RoleName'
import { usePage } from '@inertiajs/vue3'

export default function useRole() {
  const { props } = usePage()

  const canAccessAdminPanel = computed(() => {
    return props.auth.user.roles.some(role => {
      return role.name === RoleName.Admin || role.name === RoleName.Editor
    })
  })

  const isAdmin = computed(() => {
    return props.auth.user.roles.some(role => {
      return role.name === RoleName.Admin
    })
  })

  return { canAccessAdminPanel, isAdmin }
}
