<script lang="ts" setup>
import Container from "@/Components/Container.vue";
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex">
        <Container as="main" class="max-w-2xl mt-10">
            <slot />
        </Container>
    </div>
</template>
