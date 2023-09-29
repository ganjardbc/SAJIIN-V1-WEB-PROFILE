<template>
    <div id="App" class="display-popup">
        <div class="post-middle-absolute width width-400px width-mobile">
            <div class="padding padding-15px">
                <div class="card box-shadow bg-white">
                    <div class="display-flex space-between align-center">
                        <div class="fonts fonts-11 semibold black">Upload File</div>
                        <button class="btn btn-white btn-icon" @click="onClose">
                            <i class="fa fa-lg fa-times"></i>
                        </button>
                    </div>
                    <div class="margin margin-top-15px margin-bottom-15px">
                        <input 
                            type="file" 
                            placeholder="" 
                            name="image" 
                            id="image"
                            ref="file"
                            accept="image/*"
                            style="display: none;"
                            :disabled="visibleLoader"
                            @change="previewFiles">
                        <label for="image">
                            <div class="border-dashed-full border-radius" style="width: calc(100% - 8px);">
                                <div 
                                    class="image image-padding bg-white-grey" 
                                    :style="`
                                        cursor: pointer;
                                        background-image: url(${urlImage});
                                    `">
                                    <div v-if="!urlImage" class="post-middle-absolute">
                                        <i class="fa fa-3x fa-image"></i>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="width width-100">
                        <button 
                            class="btn btn-main btn-full" 
                            :disabled="!visibleUploadButton"
                            @click="onUploadImage">
                            Upload File 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'App',
    data () {
        return {
            visibleLoader: false,
            visibleLoaderAction: false,
            urlImage: '',
            formImage: '',
            visibleUploadButton: false
        }
    },
    mounted () {
        // this.$refs.file.value = null
    },
    components: {},
    props: {
        isEnable: {
            type: Boolean,
            required: false
        },
    },
    methods: {
        previewFiles(event) {
            const file = event.target.files[0]
            this.urlImage = URL.createObjectURL(file)
            this.formImage = file
            this.visibleUploadButton = true
        },
        onUploadImage() {
            this.$emit('onUpload', this.formImage)
        },
        onClose() {
            this.$emit('onClose')
        }
    },
}
</script>