<script setup>
import { onMounted, reactive, computed, ref } from 'vue';

const props = defineProps({
    servers: {
        type: String,
        default: 'api/upload'
    },
    isInvalid: {
        type: Boolean,
        default: false
    },
    media: {
        type: Array,
        default: []
    },
    location: {
        type: String,
        default: ''
    },
    max: {
        type: Number,
        default: null
    },
    maxFileSize: {
        type: Number,
        default: 4
    },
    warning: {
        type: Boolean,
        default: true
    }, 
    addeImageModel: {
        type: Array
    }
})

const emit = defineEmits(['add', 'max', 'maxFileSize', 'change', 'remove', 'init', 'update:addeImageModel']);

let savedMedia = reactive(props.media);
let addedMedia = reactive([]);
let removeMedia = reactive([]);
let isLoading = ref(false);


onMounted(() => {
    init()
})

const init = () => {
   
    savedMedia = props.media
    
    savedMedia.forEach((image, index) => {
        if(!savedMedia[index].url){
            savedMedia[index].url = props.location + "/" + image.image
        }
    })
    emit('init', allMedia)
}


const fileChange = (event) => {
    
    let files = event.target.files;

    for(var i =0; i < files.length; i++){
        if(!props.max || allMedia.length < props.max){
            if(files[i].size <= props.maxFileSize * 1000000){
                let formData = new FormData
                let url = URL.createObjectURL(files[i])
                
                let addedImage = {url: url, name:files[i].name, size: files[i].size, type: files[i].type}
                addedMedia.push(addedImage)
                emit('update:addeImageModel', files[i])
            }else{
                emit('maxFileSize', files[i].size)
                if(warning){
                    alert('The file you are trying to upload is too big. \nMaximum Filesize: '+ props.maxFilesize +'MB')
                }
                break;
            }
        }else{
            emit('max')
            if(props.warning){
                alert('You have reached the maximum number of files that you can upload. \nMaximum Files: '+ props.max)
            }
            break;
        }
    }
    event.target.value = null
    isLoading = false
}


const removeAddedMedia = (index) => {
    let removeImage = addedMedia[index]
    addedMedia.splice(index, 1)

    emit('change', allMedia)
    emit('remove', removeImage, removeMedia)
}

const removeSavedMedia =  (index) => {
    let removedImage = savedMedia[index]
    removeMedia.push(removedImage)
    savedMedia.splice(index,1)

    emit('change', allMedia)
}

const allMedia = computed(() => {
    return [...savedMedia,...addedMedia];
})

</script>
<template>
    <div class="bg-gray-100 rounded-md box-border border border-gray-200 w-full h-auto relative">
        <div v-if="isLoading" class="bg-black bg-opacity-75 w-full h-full absolute t-0 l-0 z-50 text-white text-2xl flex items-center justify-center">
            <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-red-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
            <span class="sr-only">Loading...</span>
        </div>
        <div class="p-4 flex flex-wrap">
            <!-- upload btn -->
            <div class="inline-flex m-1 h-36 w-48">
                <label for="file-input" class="bg-white border rounded-md cursor-pointer flex flex-wrap items-center h-36 w-48">
                    <svg
                        class="text-blue-500 text-xl flex-1"
                        xmlns="http://www.w3.org/2000/svg" 
                        width="1em" 
                        height="1em" 
                        preserveAspectRatio="xMidYMid meet" 
                        viewBox="0 0 24 24">
                        <g fill="none">
                        <path 
                            d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11s11-4.925 11-11S18.075 1 12 1zm1 15a1 1 0 1 1-2 0v-3H8a1 1 0 1 1 0-2h3V8a1 1 0 1 1 2 0v3h3a1 1 0 1 1 0 2h-3v3z" 
                            fill="currentColor"/>
                        </g>
                    </svg>
                </label>
                <input @change="fileChange" ref="fileInput" id="file-input" type="file" accept="image/*" multiple 
                hidden>
            </div>
            <!-- upload btn -->

            <!-- img preview -->
                <!-- saved media -->
                <div v-for="(image, index) in savedMedia" :key="index" class="relative h-36 w-48 m-1">
                    <img :src="location + image.image" alt="" class="rounded-md border border-gray-200 h-36 w-48 object-cover object-center transition ease-in-out hover:brightness-90">
                    <button @click="removeSavedMedia(index)" class="bg-red-500 rounded-full text-white border-none p-0 m-0 cursor-pointer absolute -top-1 -right-2">
                        <svg 
                            class='text-3xl hover:text-white' 
                            xmlns="http://www.w3.org/2000/svg" 
                            width="0.65em" 
                            height="0.65em" 
                            preserveAspectRatio="xMidYMid meet" 
                            viewBox="0 0 352 512">
                                <path 
                                    d="m242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28L75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256L9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"
                                    fill="currentColor"    
                                />
                        </svg>
                    </button>
                </div>
                <!-- saved media -->
                <!-- added media -->
                <div v-for="(image, index) in addedMedia" :key="index" class="relative h-36 w-48 m-1">
                    <img :src="image.url" alt="" class="rounded-md border border-gray-200 h-36 w-48 object-cover object-center transition ease-in-out hover:brightness-90">
                    <button @click="removeAddedMedia(index)" class="bg-red-500 rounded-full text-white border-none p-0 m-0 cursor-pointer absolute -top-1 -right-2">
                        <svg 
                            class='text-3xl hover:text-white' 
                            xmlns="http://www.w3.org/2000/svg" 
                            width="0.65em" 
                            height="0.65em" 
                            preserveAspectRatio="xMidYMid meet" 
                            viewBox="0 0 352 512">
                                <path 
                                    d="m242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28L75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256L9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"
                                    fill="currentColor"    
                                />
                        </svg>
                    </button>
                </div>
                <!-- added media -->
            <!-- img preview -->
        </div>
    </div>
</template>