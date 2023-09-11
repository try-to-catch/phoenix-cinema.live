<script lang="ts" setup>
import { computed } from 'vue'

const emit = defineEmits(['update:checked'])

const props = defineProps<{
  checked: boolean
  value?: boolean
}>()

const proxyChecked = computed({
  get() {
    return props.checked
  },

  set(val) {
    emit('update:checked', val)
  },
})
</script>

<template>
  <input
    v-model="proxyChecked"
    :value="value"
    class="rounded border-neutral-700 text-secondary shadow-sm focus:ring-secondary bg-primary"
    type="checkbox"
  />
</template>
