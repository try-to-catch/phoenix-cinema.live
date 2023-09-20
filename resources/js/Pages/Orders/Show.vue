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
    <section class="translate-y-1/2">
      <div class="container">
        <div class="text-white flex items-center flex-col">
          <div class="mb-2">
            <img alt="popcorn emoji" src="/images/emoji/popcorn.png" />
          </div>
          <div class="text-center space-y-3 max-w-[350px]">
            <h1 class="text-2xl">Дякуємо за покупку!</h1>
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

<style scoped></style>
