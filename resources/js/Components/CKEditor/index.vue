<script setup>
import { onMounted, ref, watch } from 'vue';

const props = defineProps({
    content: String,
});

const emit = defineEmits(['sendContent']);

let CkEditor;
const input = ref(props.content);

var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
};

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
    CkEditor = window.CKEDITOR.replace('my-editor', options);
    CkEditor.setData(input.value);
    CkEditor.on('change', () => {
        emit('sendContent', CkEditor.getData());
    });
});

defineExpose({ focus: () => input.value.focus() });

watch(input, (value) => {
   if(input.value !== CkEditor.getData()){
    CkEditor.setData(input.value);
   }
});

</script>
<template>
    <textarea id="my-editor" ref="input" :value="content" @input="$emit('sendContent', $event.target.value)"></textarea>
</template>