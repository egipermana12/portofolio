<script setup>
import { overview } from '@/Assets';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import UploadImagePrev from '@/Components/UploadImagePrev/index.vue'

const status = [
  { name: "Published", icon: overview },
  { name: "Draft", icon: overview },
  { name: "Hidden", icon: overview },
  { name: "Rejected", icon: overview },
  { name: "Under Review", icon: overview },
];

</script>

<template>
    <AdminLayout title="Dashboard">
        <main>
            <div class="flex items-center justify-between py-7 px-10">
                <div>
                    <h1 class="text-2xl font-semibold leading-relaxed text-gray-800">Products</h1>
                    <p class="text-sm font-medium text-gray-500">
                        Let's grow to your business! Create your product and upload here
                    </p>
                </div>
                <button
                    class="inline-flex gap-x-2 items-center py-2.5 px-6 text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                    >
                    <overview class="w-6 h-6 fill-current" />
                    <span class="text-sm font-semibold tracking-wide">Create Item</span>
                </button>
            </div>

            <ul class="flex gap-x-20 items-center px-4 border-y border-gray-200">
                <li v-for="item in status">
                    <button class="flex gap-x-2 items-center py-5 px-6 text-gray-500 hover:text-indigo-600 relative group">
                        <Component :is="item.icon" class="w-6 h-6 fill-current" />
                        <span class="font-medium"> {{ item.name }} </span>
                        <span
                        class="absolute w-full h-0.5 left-3 bg-indigo-600 rounded bottom-0 scale-x-0 group-hover:scale-x-100 transition-transform ease-in-out"
                        />
                    </button>
                </li>
            </ul>

            <table class="w-full border-b border-gray-200">
                <thead>
                    <tr class="text-sm font-medium text-gray-700 border-b border-gray-200">
                        <td class="pl-10">
                        <div class="flex items-center gap-x-4">
                            <input
                            type="checkbox"
                            class="w-6 h-6 text-indigo-600 rounded-md border-gray-300"
                            indeterminate="indeterminate"
                            />
                            <span>Product Name</span>
                        </div>
                        </td>
                        <td class="py-4 px-4 text-center">Pricing</td>
                        <td class="py-4 px-4 text-center">Downloaded</td>
                        <td class="py-4 px-4 text-center">Rating</td>
                        <td class="py-4 px-4 text-center">Platforms</td>
                        <td class="py-4 pr-10 pl-4 text-center">
                        <overview class="w-6 h-6 fill-current" />
                        </td>
                    </tr>
                </thead>
            </table>
            <UploadImagePrev/>
        </main>
    </AdminLayout>
</template>