<script lang="ts" setup>
defineProps({
    as: {
        type: String,
        default: "section",
    },
});
</script>

<template>
    <component :is="as" class="container mx-auto max-w-7xl px-6 lg:px-8">
        <slot />
    </component>
</template>
