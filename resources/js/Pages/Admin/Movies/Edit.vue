<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import PrimaryNavLink from '@/Components/Tables/PrimaryNavLink.vue'
import TextInput from '@/Components/Breeze/TextInput.vue'
import type { INewMovie } from '@/types/movies/INewMovie'
import InputError from '@/Components/Breeze/InputError.vue'
import TextareaInput from '@/Components/Forms/TextareaInput.vue'
import NumberInput from '@/Components/Breeze/NumberInput.vue'
import DateInput from '@/Components/Forms/DateInput.vue'
import FileInput from '@/Components/Forms/FileInput.vue'
import TextInputWithSuggestions from '@/Components/Forms/TextInputWithSuggestions.vue'
import Checkbox from '@/Components/Breeze/Checkbox.vue'
import { ref, watch } from 'vue'
import PrimaryButton from '@/Components/Breeze/PrimaryButton.vue'
import type { IGenreWithSlug } from '@/types/genres/IGenreWithSlug'
import type { Method } from 'axios'

interface IEditingMovie extends INewMovie {
  readonly slug: string
}

const { movie, genres } = defineProps<{ genres: readonly IGenreWithSlug[]; movie: IEditingMovie }>()

const today = new Date()

const form = useForm<INewMovie & { _method: Method }>({
  ...movie,
  thumbnail: null,
  banner: movie.banner ? { ...movie.banner, image: null } : null,
  _method: 'put',
})

const submitForm = () => {
  form.post(route('admin.movies.update', { movie: movie.slug }))
}

const hasBanner = ref(movie.banner !== null)

watch(hasBanner, value => {
  if (value) {
    form.banner = { fact: '', description: '', image: null }
    return
  }

  form.banner = null
})
</script>

<template>
  <Head title="Фільми" />
  <AdminLayout :is-wide="false">
    <div class="py-12">
      <div class="container">
        <div class="xl:w-4/5 2xl:w-3/4 xl:mx-auto space-y-6">
          <div class="p-4 sm:p-8 bg-tertiary border border-neutral-800 shadow sm:rounded-lg">
            <div class="flex justify-between items-center">
              <h2 class="sm:text-lg text-base font-medium text-white">Редагування фільму</h2>

              <PrimaryNavLink route-name="admin.movies.index">Повернутися</PrimaryNavLink>
            </div>

            <div class="-mx-1.5">
              <div class="flex space-x-1.5 flex-wrap space-y-1.5">
                <div v-if="typeof movie.thumbnail == 'string'" class="ml-1.5 mt-1.5">
                  <img
                    :src="movie.thumbnail"
                    alt="movie.title"
                    class="h-44 rounded-lg"
                    title="Якщо ви не хочете змінювати мініатюру, залиште поле введення файлу порожнім"
                  />
                </div>
                <div v-if="typeof movie.banner?.image == 'string'">
                  <img
                    :src="movie.banner.image"
                    alt="movie.title"
                    class="h-44 rounded-lg"
                    title="Якщо ви не хочете змінювати банер, залиште поле введення файлу порожнім"
                  />
                </div>
              </div>

              <form class="mt-4 space-y-3" @submit.prevent="submitForm">
                <div>
                  <TextInput id="title" v-model="form.title" label-inner="Назва" type="text" required />
                  <InputError :message="form.errors.title" class="mt-1.5" />
                </div>

                <div>
                  <TextInputWithSuggestions
                    id="genres"
                    v-model="form.genres"
                    label-inner="Жанри (відокрімлені пробілом)"
                    :suggestions="genres"
                  />
                  <InputError :message="form.errors.genres" class="mt-1.5" />
                </div>

                <div>
                  <TextInput
                    id="main_cast"
                    v-model="form.main_cast"
                    label-inner="В головних ролях"
                    type="text"
                    required
                  />
                  <InputError :message="form.errors.main_cast" class="mt-1.5" />
                </div>

                <div>
                  <TextareaInput id="description" v-model="form.description" rows="2" label-inner="Опис" required />
                  <InputError :message="form.errors.description" class="mt-1.5" />
                </div>

                <div class="grid sm:grid-cols-2 gap-3">
                  <div>
                    <NumberInput
                      id="priority"
                      v-model.number="form.priority"
                      label-inner="Пріорітет"
                      required
                      :max="100"
                      :min="0"
                    />
                    <InputError :message="form.errors.priority" class="mt-1.5" />
                  </div>
                  <div>
                    <NumberInput
                      id="duration_in_minutes"
                      v-model="form.duration_in_minutes"
                      label-inner="Тривалість"
                      required
                      :max="500"
                      :min="0"
                    />
                    <InputError :message="form.errors.duration_in_minutes" class="mt-1.5" />
                  </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-3">
                  <div>
                    <TextInput
                      id="age_restriction"
                      v-model="form.age_restriction"
                      label-inner="Вікові обмеження"
                      autocomplete="age_restriction"
                      type="text"
                      required
                    />
                    <InputError :message="form.errors.age_restriction" class="mt-1.5" />
                  </div>
                  <div>
                    <TextInput id="director" v-model="form.director" label-inner="Режисер" type="text" required />
                    <InputError :message="form.errors.director" class="mt-1.5" />
                  </div>
                  <div>
                    <TextInput
                      id="production_country"
                      v-model="form.production_country"
                      label-inner="Країна-виробник"
                      autocomplete="country"
                      type="text"
                      required
                    />
                    <InputError :message="form.errors.production_country" class="mt-1.5" />
                  </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-3">
                  <div>
                    <NumberInput
                      id="release_year"
                      v-model="form.release_year"
                      label-inner="Рік випуску"
                      required
                      :max="today.getFullYear()"
                      :min="0"
                    />
                    <InputError :message="form.errors.release_year" class="mt-1.5" />
                  </div>
                  <div>
                    <TextInput
                      id="original_title"
                      v-model="form.original_title"
                      label-inner="Оригінальна назва"
                      type="text"
                    />
                    <InputError :message="form.errors.original_title" class="mt-1.5" />
                  </div>
                  <div>
                    <TextInput
                      id="studio"
                      v-model="form.studio"
                      label-inner="Назва студії"
                      autocomplete="studio"
                      type="text"
                    />
                    <InputError :message="form.errors.studio" class="mt-1.5" />
                  </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-3">
                  <div>
                    <DateInput id="start_showing" v-model="form.start_showing" required label-inner="Початок показу" />
                    <InputError :message="form.errors.start_showing" class="mt-1.5" />
                  </div>

                  <div>
                    <DateInput id="end_showing" v-model="form.end_showing" required label-inner="Закінчення показу" />
                    <InputError :message="form.errors.end_showing" class="mt-1.5" />
                  </div>
                </div>

                <div>
                  <FileInput
                    id="thumbnail"
                    accept="image/*"
                    label-inner="Мініатрюра"
                    @input="form.thumbnail = $event.target.files[0]"
                  />
                  <InputError :message="form.errors.thumbnail" class="mt-1.5" />
                </div>

                <transition>
                  <div v-if="form.banner && hasBanner" class="space-y-3">
                    <TextInput id="banner_fact" v-model="form.banner.fact" label-inner="Цікавий факт" type="text" />

                    <TextareaInput
                      id="banner_description"
                      v-model="form.banner.description"
                      rows="2"
                      label-inner="Опис банера"
                      required
                    />

                    <FileInput
                      id="banner_image"
                      accept="image/*"
                      label-inner="Банер"
                      @input="form.banner.image = $event.target.files[0]"
                    />
                    <InputError :message="form.errors.banner" class="mt-1.5" />
                  </div>
                </transition>

                <div>
                  <label class="flex items-center">
                    <Checkbox v-model:checked="hasBanner" name="remember" />
                    <span class="ml-2 text-sm text-neutral-400"> Має банер? (Тільки для фільмів A класу та вище) </span>
                  </label>
                </div>

                <PrimaryButton type="submit"> Оновити </PrimaryButton>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.3s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>
