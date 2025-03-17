<script lang="ts" setup>
defineProps({
    hasError: {
        type: Boolean,
        default: false,
    },
    message: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <div v-if="hasError">
        <p class="text-sm text-red-600">{{ message }}</p>
    </div>
</template>
