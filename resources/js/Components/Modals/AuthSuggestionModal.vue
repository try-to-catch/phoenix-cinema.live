<script setup lang="ts">
import SecondaryButton from "@/Components/Breeze/SecondaryButton.vue";
import Modal from "@/Components/Breeze/Modal.vue";
import PrimaryButton from "@/Components/Breeze/PrimaryButton.vue";
import {router} from "@inertiajs/vue3";
import {ref} from "vue";

const isOpen = ref(false)
const modalController = ref<{
    resolve: (value: boolean) => void,
    reject: (reason?: any) => void
} | null>(null)

const redirectToLogin = () => {
    router.visit(route('login'))
}

const rejectAuth = () => {
    isOpen.value = false
    modalController.value?.resolve(false)
}

const open = () => {
    const modalPromise = new Promise((resolve: (value: boolean) => void, reject) => {
        modalController.value = {resolve, reject}
    });

    isOpen.value = true
    return modalPromise;
}

defineExpose<{ open: () => Promise<boolean> | never }>({open})
</script>

<template>
    <Modal max-width="2xl" :show="isOpen">
        <div class="p-6">
            <div class="flex flex-col items-center">
                <div class="w-32">
                    <img src="/images/emoji/thinking-face.png" alt="thinking face emoji" class="w-full h-full">
                </div>

                <div class="font-medium text-white text-base sm:text-lg my-3">Бажаєте авторизуватися?</div>
                <div class="text-sm sm:text-sm text-center text-neutral-400">
                    Авторизація дасть змогу зберігати квитки в особистому кабінеті, і отримувати доступ до них з
                    будь-якого пристрою
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-5">
                <SecondaryButton @click="rejectAuth">Іншого разу</SecondaryButton>

                <PrimaryButton role="link" @click="redirectToLogin">Так, звісно</PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<style scoped>

</style>
