<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Textinput from '@/Components/TextInput.vue';
import ButtonLoading from '@/Components/ButtonLoading.vue';
import { useForm } from '@inertiajs/vue3';
import CKEditor from '@/Components/CKEditor/index.vue';

const props = defineProps({
    blogs: Object,
})

const form = useForm({
    title: props.blogs.title,
    slug: props.blogs.slug,
    content: props.blogs.content,
    id: props.blogs.id  
})

const submit = () => {
    form.put(route('blogs.update', props.blogs.id));
}

const destroy = () => {
    if(confirm('Are you sure want to delete this blog?')){
        form.delete(route('blogs.destroy', props.blogs.id));
    }
}

const getContent = (val) => {
    form.content = val;
}

</script>

<template>
    <AdminLayout title="Edit Blog">
        <main>
            <div class="flex items-center justify-between py-7 px-10">
                <div>
                    <h1 class="text-2xl font-semibold leading-relaxed text-gray-800">Edit your Blogs</h1>
                    <p class="text-sm font-medium text-gray-500">
                        Let's grow to your business! edit your blog and upload here
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
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <CKEditor v-model="form.content" @sendContent="getContent" :content="form.content"></CKEditor>
                            <div class="text-sm text-red-600">{{ form.errors.content }}</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-10 bg-gray-50 border-t border-gray-100">
                        <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Your Blog</button>
                        <ButtonLoading :loading="form.processing" type="submit" class="bg-indigo-600 px-4 py-2 rounded-md font-medium text-white hover:bg-indigo-700">Update Blog</ButtonLoading>
                    </div>
                </form>
            </div>
        </main>
    </AdminLayout>
</template>