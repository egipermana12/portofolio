<script setup>
import { ref,watch } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchFilter from '@/Components/SearchFilter.vue';
import NavLinkSidebar from '@/Components/NavLinkSidebar.vue';
import Navlink from '@/Components/NavLink.vue';
import {router} from '@inertiajs/vue3';


const props = defineProps({
    blogs: Object,
    filters: Object
});


const search = ref(props.filters.search);

const reset = () => {
    search.value = "";
}

watch(search, (value) => {
    router.get("/blogs", {search: value}, {preserveState: true});
});

</script>
<template>
    <AdminLayout title="Blog">
        <main>
            <div class="flex items-center justify-between py-7 px-10">
                <div>
                    <h1 class="text-2xl font-semibold leading-relaxed text-gray-800">Blogs</h1>
                    <p class="text-sm font-medium text-gray-500">
                        Let's grow to your business! Create your blog and upload here
                    </p>
                </div>
            </div>
            <div class="flex items-center justify-between mb-6 px-10">
                <SearchFilter @reset="reset" v-model="search">
                </SearchFilter>
                <NavLinkSidebar :href="route('blogs.create')" :active="route().current('blogs.index')">
                    <button
                        class="inline-flex gap-x-2 items-center py-2.5 px-6 text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                        >
                        <span class="text-sm font-semibold tracking-wide">Create Blog</span>
                    </button>
                </NavLinkSidebar>
            </div>
            <table class="w-full border-b border-t border-gray-200">
                <thead>
                    <tr class="text-sm font-medium text-gray-700 border-b border-gray-200">
                        <td class="pl-10">
                        <div class="flex items-center gap-x-4">
                            <span>Title</span>
                        </div>
                        </td>
                        <td class="py-4 px-4 text-center">Slug</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="blog in props.blogs.data" :key="blog.id" class="hover:bg-gray-100 transition-colors group"> 
                        <td class="flex gap-x-4 items-center py-4 pl-10">
                            <Navlink :href="route('blogs.edit', blog.id)" class="font-medium text-left">
                                {{ blog.title }}
                            </Navlink>
                        </td>
                        <td class="font-medium text-left pr-10">{{ blog.slug }}</td>
                        
                    </tr>
                </tbody>
            </table>
            <Pagination :links="props.blogs.links" />
        </main>
    </AdminLayout>
</template>