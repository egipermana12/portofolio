<script setup>
import axios from 'axios';
import { onMounted, reactive, computed, ref } from 'vue';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')


let files = reactive([])
let uploadedFile = reactive([])
let showProgress = ref(false)


const uploadFile = (e) => {
    const file = e.target.files[0]
    if (!file) return
    const fileName = (file.name.length >= 12) ? file.name.substring(0, 13) + '... .' + file.name.split('.')[1] : file.name
    const formData = new FormData()
    formData.append('image', file)
    files.push({ name: fileName, loading: 0, url: URL.createObjectURL(file) })
    showProgress = true

    axios.post('upload-file', formData, {
        onUploadProgress: ({ loaded, total }) => {
            files[files.length - 1].loading = Math.floor((loaded / total) * 100)
            if (loaded == total) {
                const fileSize = (total < 1024) ? total + ' KB' : (loaded / (1024 * 1024)).toFixed(2) + ' MB'
                files = []
                showProgress = false
            }
        },
        
    })
    .then(function (res) {
        uploadedFile.push({ name: res.data.fileName, path: res.data.path })
    })
    .catch(console.error)
}

</script>
<template>
    <div class="bg-gray-100 rounded-md box-border border border-gray-200 w-full h-auto relative">
        <div class="p-4 flex flex-wrap">
            <!-- upload btn -->
            <div class="inline-flex m-1 h-36 w-48">
                <label @click="$refs.fileInput.click()"
                    class="bg-white border rounded-md cursor-pointer flex flex-wrap items-center h-36 w-48">
                    <svg class="text-blue-500 text-xl flex-1" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <g fill="none">
                            <path
                                d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11s11-4.925 11-11S18.075 1 12 1zm1 15a1 1 0 1 1-2 0v-3H8a1 1 0 1 1 0-2h3V8a1 1 0 1 1 2 0v3h3a1 1 0 1 1 0 2h-3v3z"
                                fill="currentColor" />
                        </g>
                    </svg>
                </label>
                <input @change="uploadFile" ref="fileInput" name="fileInput" type="file" accept="image/*" multiple hidden>
            </div>
            <!-- upload btn -->

            <!-- img preview -->
            <!-- saved media -->
            <div v-for="(image, index) in files" :key="index" class="relative h-36 w-48 m-1">
                <img :src="image.url" alt=""
                    class="bg-green-200 rounded-md border border-gray-200 h-36 w-48 object-cover object-center transition ease-in-out hover:brightness-90">
                <!-- progress bar -->
                <div v-if="showProgress"
                    class="w-4/5 bg-gray-100 rounded-full h-1.5 absolute top-1/2 left-1/2 transform -translate-x-2/4">
                    <div class="bg-green-600 h-1.5 rounded-full" :style="{ width: image.loading + '%' }"></div>
                </div>
                <!-- progress bar -->
                <button @click=""
                    class="bg-red-500 rounded-full text-white border-none p-0 m-0 cursor-pointer absolute -top-1 -right-2">
                    <svg class='text-3xl hover:text-white' xmlns="http://www.w3.org/2000/svg" width="0.65em" height="0.65em"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 352 512">
                        <path
                            d="m242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28L75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256L9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"
                            fill="currentColor" />
                    </svg>
                </button>
            </div>
            <!-- added media -->
            <!-- saved media -->
            <div v-for="(image, index) in uploadedFile" :key="index" class="relative h-36 w-48 m-1">
                <img :src="image.path" :alt="image.name"
                    class="bg-green-200 rounded-md border border-gray-200 h-36 w-48 object-cover object-center transition ease-in-out hover:brightness-90">
                
            </div>
            <!-- saved media -->
            <!-- img preview -->

        </div>
    </div>
</template>