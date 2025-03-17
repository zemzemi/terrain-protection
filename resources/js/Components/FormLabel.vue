<script lang="ts" setup>
defineProps<{
    label: string;
}>();
</script>

<template>
    <label class="text-md block font-medium text-gray-800" v-text="label" />
</template>
