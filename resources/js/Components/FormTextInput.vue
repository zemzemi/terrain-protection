<script lang="ts" setup>
import { defineProps, withDefaults, defineEmits, ref, computed } from "vue";
import FormLabel from "./FormLabel.vue";
import FormErrorMessage from "./FormErrorMessage.vue";
import { v4 as uuid } from "uuid";

interface IFormTextInputProps {
    id?: string;
    label: string;
    modelValue: string | number;
    type?: string;
    required?: boolean;
    disabled?: boolean;
    placeholder?: string;
    helper?: string;
    error?: string;
}

const props = withDefaults(defineProps<IFormTextInputProps>(), {
    id: () => `textarea-${uuid()}`,
    type: "text",
    required: false,
    disabled: false,
    placeholder: "",
    helper: "",
    error: "",
});

const emit = defineEmits(["update:modelValue"]);

const input = ref<HTMLInputElement | null>(null);
const hasError = computed(() => props.error !== "");
const errorMessage = computed(() => props.error);
const inputClasses = computed(() => ({
    "text-input": true,
    "text-input-error": hasError.value,
}));

const textLabel = computed(() =>
    props.required ? `${props.label}*` : props.label,
);
</script>

<template>
    <div>
        <FormLabel class="mb-1" :label="textLabel" :for="id" />

        <input
            :id="id"
            ref="input"
            :type="type"
            :class="inputClasses"
            :value="modelValue"
            :placeholder="placeholder"
            :required="required"
            :disabled="disabled"
            @input="
                ($event: Event) =>
                    emit(
                        'update:modelValue',
                        ($event.target as HTMLInputElement).value,
                    )
            "
        />

        <p v-if="helper" class="my-2 text-sm text-gray-400">
            {{ helper }}
        </p>

        <FormErrorMessage
            class="mt-2"
            :has-error="hasError"
            :message="errorMessage"
        />
    </div>
</template>

<style scoped>
.text-input {
    @apply block w-full rounded-md border border-gray-300 px-3.5 py-2 text-gray-900 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:bg-white focus:ring-indigo-500;
}

.text-input-error {
    @apply border-red-300 focus:border-red-500 focus:ring-red-500;
}
</style>
