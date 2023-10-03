<script setup>
import { onMounted, ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue', 'reset']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

</script>

<template>
    <div class="flex items-center">
        <div class="flex items-center w-full bg-white rounded shadow">
            <Dropdown :auto-close="false"  class="focus:z-10 px-4 hover:bg-gray-100 border-r focus:border-white rounded-l focus:ring md:px-6" placement="bottom-start">
                <template #trigger>
                    <div class="flex items-baseline">
                        <span class="hidden text-gray-700 md:inline">Search</span>
                    </div>
                </template>
            </Dropdown>
            <input ref="input" class="relative px-6 py-3 w-full rounded-r focus:shadow-outline" autocomplete="off" type="text" name="search" placeholder="Search…" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
        </div>
        <button class="ml-3 text-gray-500 hover:text-gray-700 focus:text-indigo-500 text-sm" type="button" @click="$emit('reset')">Reset</button>
    </div>
</template>