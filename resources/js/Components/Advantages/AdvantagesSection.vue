<script setup lang="ts">
import AdvantageItem from "@/Components/Advantages/AdvantageItem.vue";
import H3Title from "@/Components/Titles/H3Title.vue";
</script>

<template>
    <section>
        <div class="container">
            <H3Title>Наші особливості</H3Title>

            <ul class="grid sm:grid-cols-2 h-full gap-5 mt-5 text-white">
                <AdvantageItem title="Круті окуляри">
                    <template #text>
                        Насолоджуйтесь неперевершеним 3D-досвідом завдяки нашим легким та зручним крутим окулярам.
                        Чітке та реалістичне зображення забезпечує максимальний комфорт під час перегляду фільмів.
                        Відчуйте себе у центрі подій!
                    </template>

                    <template #emoji>
                        <div class="absolute md:w-16 w-10 top-1 md:-top-6 md:right-4 right-2 origin-top-left rotate-12">
                            <img src="/images/emoji/smiling-face-with-sunglasses.png"
                                 alt="smiling face with sunglasses">
                        </div>
                    </template>
                </AdvantageItem>

                <AdvantageItem title="Новітні технології звуку">
                    <template #text>
                        Ми прагнемо надати незабутні враження нашим глядачам. Кінозали оснащені передовими
                        технологіями звуку, створюючи реалістичну обстановку. Захоплюючий звук зі всіх боків
                        допомагає зануритися в атмосферу фільму.
                    </template>

                    <template #emoji>
                        <div
                            class="absolute md:w-16 w-10 top-1 md:-top-6 lg:right-4 md:-right-4 right-2 origin-top-left rotate-6">
                            <img src="/images/emoji/speaker-high-volume.png"
                                 alt="speaker high volume">
                        </div>
                    </template>
                </AdvantageItem>

                <AdvantageItem title="Розкішні кінозали">
                    <template #text>
                        Наши кінозали — це втілення розкіші та комфорту. Широкі м'які крісла забезпечують ідеальну
                        підтримку для вашої спини, а елегантний дизайн створює неповторну атмосферу.
                    </template>

                    <template #emoji>
                        <div class="absolute md:w-16 w-10 top-1 md:-top-6 md:right-4 right-2 origin-top-left rotate-6">
                            <img src="/images/emoji/classical-building.png"
                                 alt="classical high building">
                        </div>
                    </template>
                </AdvantageItem>

                <AdvantageItem title="Великий вибір фільмів">
                    <template #text>
                        Ми розуміємо, що смаки глядачів різняться, тому пропонуємо широкий вибір фільмів у різних
                        жанрах. Від захоплюючих екшнів та непередбачуваних детективів до романтичних комедій та
                        фантастичних пригод — кожен знайде щось, що відповідає його смаку.
                    </template>

                    <template #emoji>
                        <div
                            class="absolute md:w-16 w-10 top-1 md:-top-6 lg:right-4 md:-right-4 right-2 origin-top-left rotate-6">
                            <img src="/images/emoji/clapper-board.png"
                                 alt="clapper board">
                        </div>
                    </template>
                </AdvantageItem>
            </ul>
        </div>
    </section>
</template>

