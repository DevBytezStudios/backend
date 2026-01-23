<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import { computed } from 'vue';

interface Props {
    modelValue: string;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

const MAX_LENGTH = 11;

const formatPhone = (value: string) => {
    const numbers = value.replace(/\D/g, '');

    if (numbers.length > 11) {
        numbers.slice(0, MAX_LENGTH);
    }
    if (numbers.length <= 10) {
        return numbers.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    }

    return numbers.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
};

const phoneFormatted = computed({
    get() {
        return formatPhone(props.modelValue || '');
    },
    set(value: string) {
        const numbers = value.replace(/\D/g, '');

        if (numbers.length > MAX_LENGTH) {
            emit('update:modelValue', numbers.slice(0, MAX_LENGTH));
            return;
        }

        emit('update:modelValue', numbers);
    },
});
</script>

<template>
    <Input type="tel" placeholder="(99) 99999-9999" v-model="phoneFormatted" />
</template>
