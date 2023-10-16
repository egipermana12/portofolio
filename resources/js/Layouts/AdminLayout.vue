<script setup>
import {ref} from 'vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Header from '@/Components/Header.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

defineProps({
    title: String,
});


</script>

<style>
    .ck.ck-content.ck-editor__editable.ck-rounded-corners.ck-editor__editable_inline.ck-blurred{
        height: 400px !important;
        border: 1px solid #c8c8c8;
    }
    .ck.ck-content.ck-editor__editable.ck-rounded-corners.ck-editor__editable_inline.ck-focused{
        height: 400px !important;
    }
    
</style>

<template>
    <div>
        <Head :title="title" />

        <div class="w-full min-h-screen font-sans text-gray-900 bg-gray-50 flex">
            <Sidebar :href="$page.url"/>

            <main class="flex-1 pb-8 ml-64 h-full overflow-x-hidden">
                <Header />
                <div class="px-10 pt-7">
                    <FlashMessage />
                </div>
                <main class="min-h-screen">
                    <slot />
                </main>
            </main>
        </div>
    </div>
</template>