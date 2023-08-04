<script setup lang="ts">

import ApplicationLogo from "@/Components/Icons/ApplicationLogo.vue";
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <div class="font-sans-serif w-full min-h-screen flex flex-col bg-primary">
        <header>
            <div class="container py-2 flex items-center justify-between">
                <div>
                    <Link :href="route('home')">
                        <ApplicationLogo/>
                    </Link>
                </div>

                <div class="text-secondary space-x-2 flex">
                    <Link :href="route('login')">Вхід</Link>
                    <div>|</div>
                    <Link :href="route('register')">Реєстрація</Link>
                </div>
            </div>

        </header>

        <main class="flex-grow">
            <slot/>
        </main>

        <footer class="bg-tertiary w-full flex justify-center border-t border-gray-700">
            <div class="text-sm py-4 text-gray-400">© 2022-2023 PX-Phoenix Holding. Всі права захищено</div>
        </footer>
    </div>
</template>

<style scoped>

</style>
