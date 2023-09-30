<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
    ? 'flex gap-x-4 items-center py-2 text-gray-500 hover:text-indigo-600 text-indigo-600 group'
    : 'flex gap-x-4 items-center py-2 text-gray-500 hover:text-indigo-600 group';
});



</script>

<template>
    <Link :href="href" :class="classes">
            <span v-if="props.active"
                            class="absolute w-1.5 h-8 bg-indigo-600 rounded-r-full left-0 scale-y-0 -translate-x-full scale-y-100 translate-x-0 transition-transform ease-in-out"
                            />
                            <span v-else
                            class="absolute w-1.5 h-8 bg-indigo-600 rounded-r-full left-0 scale-y-0 -translate-x-full group-hover:scale-y-100 group-hover:translate-x-0 transition-transform ease-in-out"
                            />
        <slot />
    </Link>
</template>