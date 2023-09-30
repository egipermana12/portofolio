<script setup>
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    links: Array
})

</script>

<template>
    <div v-if="props.links.length > 3" class="flex justify-center mt-4 space-x-4">
        <div class="flex flex-wrap mt-8">
            <template v-for="(link, key) in links" :key="key">
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label"
                />

                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-gray-200 focus:text-gray-200"
                    :class="{ 'bg-indigo-700 text-white': link.active }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
