<script lang="ts" setup>
import {ref, watch} from 'vue';
import ApplicationLogo from '@/Components/Icons/ApplicationLogo.vue';
import NavLink from '@/Components/Breeze/NavLink.vue';
import ResponsiveNavLink from '@/Components/Breeze/ResponsiveNavLink.vue';
import {Link} from '@inertiajs/vue3';
import DefaultDropdown from "@/Layouts/Shared/DefaultDropdown.vue";
import Hamburger from "@/Components/Icons/Hamburger.vue";
import useWindow from "@/composables/window";

const showingNavigationDropdown = ref(false)

const {width: windowWidth} = useWindow()

watch(windowWidth, () => {
  if (windowWidth.value >= 640 && showingNavigationDropdown.value === true) {
    document.body.style.overflow = 'auto'
  }
})


watch(showingNavigationDropdown, () => {
  if (showingNavigationDropdown.value) {
    document.body.style.overflow = 'hidden'
    return
  }

  document.body.style.overflow = 'auto'
})
</script>

<template>
  <div>
    <div class="min-h-screen bg-tertiary">
      <nav class="bg-primary shadow-md border-b border-neutral-700 sm:border-none">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-[50px]">
            <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                <Link :href="route('home')">
                  <ApplicationLogo
                      class="block w-auto fill-current text-secondary"
                  />
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLink :active="route().current('home')" :href="route('home')">
                  Dashboard
                </NavLink>
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
              <!-- Settings Dropdown -->
              <div class="ml-3 relative">
                <div v-if="$page.props.auth.user.name" class="ml-3 relative">
                  <DefaultDropdown :user-name="$page.props.auth.user.name"/>
                </div>
              </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
              <button
                  class="inline-flex items-center justify-center p-2 rounded-md text-secondary hover:text-orange-600 hover:bg-neutral-800 focus:outline-none focus:bg-neutral-800 focus:text-orange-600 transition duration-150 ease-in-out"
                  @click="showingNavigationDropdown = !showingNavigationDropdown"
              >
                <Hamburger :is-active="showingNavigationDropdown" class="fill-secondary w-6 h-6"/>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
            :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
            class="sm:hidden right-0 left-0 absolute h-full z-20 bg-primary"
        >
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink :active="route().current('home')" :href="route('home')">
              Dashboard
            </ResponsiveNavLink>
          </div>

          <!-- Responsive Settings Options -->
          <div class="pt-4 pb-1 border-t border-neutral-200">
            <div class="px-4">
              <div class="font-medium text-base text-white">
                {{ $page.props.auth.user.name }}
              </div>
              <div class="font-medium text-sm text-neutral-400">{{ $page.props.auth.user.email }}</div>
            </div>

            <div class="mt-3 space-y-1">
              <ResponsiveNavLink :href="route('profile.edit')">Профіль</ResponsiveNavLink>
              <ResponsiveNavLink :href="route('logout')" as="button" method="post">
                Вийти
              </ResponsiveNavLink>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Content -->
      <main>
        <slot/>
      </main>
    </div>
  </div>
</template>
