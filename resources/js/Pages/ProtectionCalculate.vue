<script lang="ts" setup>
import { useForm } from "@inertiajs/vue3";
import FormTextInput from "@/Components/FormTextInput.vue";
import FormTextField from "@/Components/FormTextField.vue";
import BaseButton from "@/Components/Button.vue";
import { defineProps, computed } from "vue";

interface Props {
    result: number | null;
}

const props = defineProps<Props>();

const form = useForm({
    width: "",
    altitudes: "",
});

const submitForm = async () => {
    form.post(route("terrain-protection.calculate"), {
        preserveState: true,
    });
};

const protectedArea = computed(() => {
    if (form.processing) {
        return "Calculating...";
    }

    return props.result ?? null;
});
</script>

<template>
    <form
        class="space-y-6 p-6 bg-white shadow rounded"
        @submit.prevent="submitForm"
    >
        <h2 class="text-2xl font-semibold mb-4">
            Terrain Protection Calculator
        </h2>

        <FormTextInput
            id="width"
            v-model="form.width"
            label="Width"
            required
            type="number"
            placeholder="Example: 5"
            :error="form.errors.width"
        />

        <FormTextField
            id="altitudes"
            v-model="form.altitudes"
            label="Altitudes"
            required
            :error="form.errors.altitudes"
        />

        <BaseButton :disabled="form.processing" type="submit">
            Calculate
        </BaseButton>
    </form>

    <div
        v-if="protectedArea !== null"
        class="mt-4 bg-white shadow p-6 rounded text-gray-900"
    >
        <strong>Protected Area:</strong> {{ protectedArea }}
    </div>
</template>
