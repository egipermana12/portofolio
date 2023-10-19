<script setup>
import { onMounted, reactive } from 'vue';

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
    }
})

const emit = defineEmits(['add', 'max', 'maxFileSize', 'change', 'remove']);

let addedMedia = reactive([]);
let removeMedia = reactive([]);

const fileChange = (event) => {
    //untuk loading
    let files = event.target.files;

    for(var i =0; i < files.length; i++){
        if(!props.max || allMedia.length < props.max){
            if(files[i].size <= props.maxFileSize * 1000000){
                let formData = new FormData
                let url = URL.createObjectURL(files[i])
                formData.set('image', files[i])

                console.log(files[i])

                // for send data to server
                let addedImage = {url: url, name:'', size: files[i].size, type: files[i].type}
                addedMedia.push(addedImage)
                emit('add', addedImage, addedMedia)
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
    // props.isLoading = false
}

const removeAddedMedia = (index) => {
    let removeImage = addedMedia[index]
    addedMedia.splice(index, 1)

    emit('change', allMedia)
    emit('remove', removeImage, removeMedia)
}

const allMedia = () => {
    return [...addedMedia];
}

</script>
<template>
    <div class="bg-gray-100 rounded-md box-border border border-gray-200 w-full h-auto">
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
                <input @change="fileChange" id="file-input" type="file" accept="image/*" multiple hidden>
            </div>
            <!-- upload btn -->

            <!-- img preview -->
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