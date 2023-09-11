import { onMounted, onUnmounted, ref } from 'vue'

const width = ref(window.innerWidth)
export default function useWindow() {
  const resizeHandler = () => {
    width.value = window.innerWidth
  }

  onMounted(() => {
    window.addEventListener('resize', resizeHandler)
  })

  onUnmounted(() => {
    window.removeEventListener('resize', resizeHandler)
  })

  return { width }
}
