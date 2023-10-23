<script setup>
import { onMounted, ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Textinput from '@/Components/TextInput.vue';
import CKEditor from '@/Components/CKEditor/index.vue';
import ButtonLoading from '@/Components/ButtonLoading.vue';
import { useForm } from '@inertiajs/vue3';


const form = useForm({
    title: '',
    slug: '',
    content: 'Hello World!',
    image: null   
})

const submit = () => {
    form.post(route('blogs.store'));
}

const getContent = (val) => {
    form.content = val;
}

</script>

<template>
    <AdminLayout title="Create Blog">
        <main>
            <div class="flex items-center justify-between py-7 px-10">
                <div>
                    <h1 class="text-2xl font-semibold leading-relaxed text-gray-800">Create New Blogs</h1>
                    <p class="text-sm font-medium text-gray-500">
                        Let's grow to your business! Create your blog and upload here
                    </p>
                </div>
            </div>
            <div class="px-10 w-4/5">
                <form @submit.prevent="submit">
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Blog Title</label>
                            <Textinput v-model="form.title" :error="form.errors.title" class="w-full" placeholder="Type blog title"></Textinput>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Blog Slug</label>
                            <Textinput v-model="form.slug" :error="form.errors.slug"  class="w-full" placeholder="Type blog slug"></Textinput>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Blog Image</label>
                            <input type="file" @input="form.image = $event.target.files[0]" />
                        </div>
                        <div class="sm:col-span-2">
                            <label for="description2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <CKEditor v-model="form.content" @sendContent="getContent" :content="form.content"></CKEditor>
                            <div class="text-sm text-red-600">{{ form.errors.content }}</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end py-10 bg-gray-50 border-t border-gray-100">
                        <ButtonLoading :loading="form.processing" type="submit" class="bg-indigo-600 px-4 py-2 rounded-md font-medium text-white hover:bg-indigo-700">Create Blog</ButtonLoading>
                    </div>
                </form>
            </div>
        </main>
    </AdminLayout>
</template>