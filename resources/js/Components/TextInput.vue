<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    error: String,
    type: {
        type: String,
        default: 'text'
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});


defineExpose({ focus: () => input.value.focus() });
</script>


<template>
    <div class="flex flex-col">
        <input
            ref="input"
            :type="type"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            :class="{error: error , 'border-red-300 focus:border-red-500 focus:ring-red-500 ' : error}"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        >
        <span class="text-red-600 text-sm">{{ error }}</span>
    </div>
</template>
