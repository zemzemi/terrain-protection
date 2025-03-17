<script lang="ts" setup>
import { defineProps, withDefaults } from "vue";

type ButtonType = "default" | "primary" | "secondary" | "danger" | "submit";
type ButtonSize = "sm" | "md";

const props = withDefaults(
    defineProps<{
        type?: ButtonType;
        size?: ButtonSize;
        processing?: boolean;
    }>(),
    {
        type: "primary",
        size: "md",
        processing: false,
    },
);
</script>

<template>
    <button
        :class="[
            'btn',
            `btn-${props.size}`,
            `btn-${props.type}`,
            { 'opacity-25': props.processing },
        ]"
        :type="props.type === 'submit' ? 'submit' : 'button'"
        :disabled="props.processing"
    >
        <slot />
    </button>
</template>

<style scoped>
.btn {
    @apply inline-flex items-center justify-center rounded-md border border-transparent font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2;
}
.btn-sm {
    @apply px-4 py-2 text-xs;
}
.btn-md {
    @apply px-5 py-3 text-sm;
}
.btn-default {
    @apply bg-gray-600 hover:bg-gray-700 focus:bg-gray-700 focus:ring-gray-500 active:bg-gray-900;
}
.btn-primary,
.btn-submit {
    @apply bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 focus:ring-indigo-500 active:bg-indigo-900;
}
.btn-secondary {
    @apply border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:bg-gray-50;
}
.btn-danger {
    @apply bg-red-600 hover:bg-red-700 focus:bg-red-700 focus:ring-red-500 active:bg-red-900;
}
</style>
