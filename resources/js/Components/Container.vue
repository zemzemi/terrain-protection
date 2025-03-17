<script lang="ts" setup>
import { defineProps, withDefaults } from "vue";

type ContainerAsType = "section" | "main" | "div";

withDefaults(
    defineProps<{
        as: ContainerAsType;
    }>(),
    {
        as: "section",
    },
);
</script>

<template>
    <component :is="as" class="container mx-auto max-w-7xl px-6 lg:px-8">
        <slot />
    </component>
</template>
