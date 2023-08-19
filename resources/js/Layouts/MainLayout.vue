<script lang="ts" setup>

import ApplicationLogo from "@/Components/Icons/ApplicationLogo.vue";
import {Link} from "@inertiajs/vue3";
import DropdownLink from "@/Components/Breeze/DropdownLink.vue";
import Dropdown from "@/Components/Breeze/Dropdown.vue";
import AngleDown from "@/Components/Icons/AngleDown.vue";
</script>

<template>
  <div class="font-sans-serif w-full min-h-screen flex flex-col bg-primary relative">
    <header class="fixed w-full z-20 sm:bg-primary bg-tertiary h-[50px] border-b border-neutral-700 sm:border-none">
      <div class="container py-2 flex items-center justify-between h-full">
        <div>
          <Link :href="route('home')">
            <ApplicationLogo/>
          </Link>
        </div>

        <div v-if="!$page.props.auth.user" class="text-secondary space-x-2 flex text-sm md:text-base">
          <Link :href="route('login')">Вхід</Link>
          <div class="sm:block hidden">|</div>
          <Link :href="route('register')">Реєстрація</Link>
        </div>

        <div v-if="$page.props.auth.user" class="ml-3 relative">
          <Dropdown align="right" width="48">
            <template #trigger>
              <span class="inline-flex rounded-md">
                <button
                    class="inline-flex items-center px-3 py-2 border border-transparent sm:text-base text-sm leading-4 font-medium rounded-md text-secondary bg-tertiary sm:bg-primary hover:text-orange-600 focus:outline-none transition ease-in-out duration-300"
                    type="button"
                >
                  {{ $page.props.auth.user.name }}
                  <AngleDown/>
                </button>
              </span>
            </template>

            <template #content>
              <DropdownLink :href="route('profile.edit')"> Profile</DropdownLink>
              <DropdownLink :href="route('logout')" as="button" method="post">
                Log Out
              </DropdownLink>
            </template>
          </Dropdown>
        </div>
      </div>

    </header>

    <main class="flex-grow mt-[50px]">
      <slot/>
    </main>

    <footer class="bg-tertiary w-full border-t border-neutral-800 text-center hidden sm:block">
      <div class="text-sm py-4 text-neutral-400">© 2022-2023 PX-Phoenix Holding. Всі права захищено</div>
    </footer>
  </div>
</template>

<style scoped>

</style>
