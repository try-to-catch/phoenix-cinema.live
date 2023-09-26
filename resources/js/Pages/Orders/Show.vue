<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue'
import SecondaryButton from '@/Components/Breeze/SecondaryButton.vue'

defineProps<{ order: { id: string } }>()
</script>

<template>
  <Head title="Дякуємо за покупку!" />
  <MainLayout>
    <section :class="$style['content']">
      <div class="container">
        <div class="text-white flex items-center flex-col">
          <div :class="$style['content__emoji']" class="mb-2">
            <img alt="popcorn emoji" class="h-full" src="/images/emoji/popcorn.png" />
          </div>
          <div class="text-center space-y-3 max-w-[350px]">
            <h1 class="md:text-2xl text-xl">Дякуємо за покупку!</h1>
            <p class="text-sm">Радимо приходити раніше, щоб всигнути купити попкорн та напої</p>
            <div class="grid grid-cols-1 gap-2.5">
              <a :href="route('orders.download', { order: order.id })">
                <PrimaryButton>Скачати білети</PrimaryButton>
              </a>
              <Link :href="route('home')">
                <SecondaryButton>На головну</SecondaryButton>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<style module>
.content {
  transform: translateY(50%);
}

@media (max-height: 700px) {
  .content {
    transform: translateY(30%);
  }
}

@media (max-height: 570px) {
  .content {
    margin-top: 20px;
    transform: translateY(0%);
  }
}

@media (max-height: 570px) {
  .content__emoji {
    height: 100px;
    overflow: hidden;
  }
}

@media (max-height: 570px) {
  .content__emoji {
    height: 30px;
  }
}
</style>
