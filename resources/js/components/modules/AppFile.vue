<template>
    <div id="AppImage">
        <div style="width: 100%;">
            <div v-if="this.image" class="display-flex border-full" style="border-radius: 3px; overflow: hidden; margin-bottom: 15px;">
                <input 
                    type="text" 
                    class="field"
                    placeholder="" 
                    name="file_name" 
                    id="file_name"
                    style="width: calc(100% - 45px); border-radius: 0;"
                    :value="this.image"
                    readonly>
                <button 
                    v-if="this.image !== '' ? this.isEnable ? true : false : false" 
                    class="btn btn-icon btn-white" 
                    style="border-radius: 0;"
                    title="remove image" 
                    @click="onRemove">
                    <i class="fa fa-1x fa-trash-alt" />
                </button>
            </div>
            <input 
                v-if="this.isEnable"
                type="file" 
                placeholder="" 
                name="file" 
                id="file"
                ref="file"
                accept="audio/*"
                :disabled="visibleLoader"
                @change="previewFiles">
        </div>
        <div v-if="isEnable" style="width: 100%; padding-top: 5px;">
            <button 
                v-if="!visibleUploadButton"
                :class="'btn btn-full btn-primary'" 
                title="choose image" 
                style="margin-top: 10px; cursor: not-allowed;" 
                disabled>
                Upload
            </button>
            <button 
                v-else 
                :class="'btn btn-full ' + (visibleLoader ? 'btn-primary' : 'btn-main')" 
                title="upload image" 
                style="margin-top: 10px;" 
                :disabled="visibleLoader"
                @click="onUploadImage">
                {{ visibleLoader ? 'Please Wait ..' : 'Upload' }}
            </button>
        </div>

        <!-- <AppAlert 
            v-if="visibleLoader" 
            :isLoader="visibleLoaderAction" /> -->
    </div>
</template>
<script>
import AppAlert from './AppAlert'
export default {
    name: 'AppImage',
    data () {
        return {
            visibleLoader: false,
            visibleLoaderAction: false,
            formImage: '',
            visibleUploadButton: false
        }
    },
    mounted () {
        this.$refs.file.value = null
    },
    components: {
        AppAlert
    },
    props: {
        image: {
            type: String,
            required: true
        },
        isEnable: {
            type: Boolean,
            required: false
        },
        onChange: {
            type: Function,
            required: false
        },
        onRemove: {
            type: Function,
            required: false
        },
        onUpload: {
            type: Function,
            required: false
        }
    },
    methods: {
        previewFiles(event) {
            const file = event.target.files[0]
            this.formImage = file
            this.visibleUploadButton = true
            console.log('file', file)
        },
        onUploadImage() {
            this.onUpload(this.formImage)
            this.visibleLoader = true
            this.visibleLoaderAction = true 
        }
    },
    watch: {
        image: function (props, prevProps) {
            // if (props) {
            //     this.formImage = props
            // } else {
            //     this.formImage = []
            // }
            // console.log('image', props)
            this.$refs.file.value = null
            this.visibleUploadButton = false
            this.visibleLoader = false
            this.visibleLoaderAction = false 
        }
    }
}
</script>