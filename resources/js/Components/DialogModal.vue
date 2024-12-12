<template>
    <div v-if="show" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="closeable ? close() : null"></div>

        <!-- Kontener modalu -->
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden transform transition-all max-w-full" :class="`max-w-${maxWidth}`">
            <!-- Zawartość modalu -->
            <div class="px-6 py-4">
                <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    <slot name="title" />
                </div>

                <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                    <slot name="content" />
                </div>
            </div>

            <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 dark:bg-gray-800 text-end">
                <slot name="footer" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const emit = defineEmits(['close']);
defineProps({
    show: {type: Boolean, required: true},
    maxWidth: {type: String, default: '2xl'},
    closeable: {type: Boolean, default: true},
});

const close = () => {
    emit('close');
};
</script>
