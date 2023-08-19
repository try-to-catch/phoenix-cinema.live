<script setup lang="ts">
import {computed} from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps<{
  checked: boolean;
  value?: any;
}>();

const proxyChecked = computed({
  get() {
    return props.checked;
  },

  set(val) {
    emit('update:checked', val);
  },
});
</script>

<template>
  <input
      type="checkbox"
      :value="value"
      v-model="proxyChecked"
      class="rounded border-neutral-700 text-secondary shadow-sm focus:ring-secondary bg-primary"
  />
</template>
