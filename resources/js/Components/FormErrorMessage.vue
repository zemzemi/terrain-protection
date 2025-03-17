<script lang="ts" setup>
import { defineProps, withDefaults } from "vue";

interface Props {
    hasError: boolean;
    message: string | string[];
}

withDefaults(defineProps<Props>(), {
    hasError: false,
    message: "",
});
</script>

<template>
    <div v-if="hasError">
        <p v-if="typeof message === 'string'" class="text-sm text-red-600">
            {{ message }}
        </p>
        <ul v-else class="text-sm text-red-600">
            <li v-for="(msg, index) in message" :key="index">{{ msg }}</li>
        </ul>
    </div>
</template>
