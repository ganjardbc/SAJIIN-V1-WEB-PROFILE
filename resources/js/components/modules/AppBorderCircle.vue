<template>
    <div id="App" style="padding-bottom: 10px; padding-top: 10px;">
        <div class="theme-border-circle">
            <div class="post-middle-absolute cover">
                <div class="image image-padding image-circle image-center" :style="'background-image: url(' + image + ')'" title="click to open image"></div>
            </div>
            <img v-if="!disableBorder" class="border" style="width: 120%; left: -10%; top: -10%;" :src="border" />
        </div>

        <div v-if="visiblePopup" class="display-popup" @click="openImage">
            <div class="width width-full width-mobile post-middle">
                <div class="image image-padding" style="border-radius: 0; background-color: rgba(0, 0, 0, 0);">
                    <img class="img" :src="cover ? cover : image" alt="">
                </div>
            </div>

            <div style="position: absolute; left: 0; bottom: 15px; width: 100%; text-align: center;">
                <button class="btn btn-black" style="border-radius: 0; margin: auto;">
                    <i class="icn icn-left fa fa-lg fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    name: 'App',
    data () {
        return {
            visiblePopup: false,
            border: '/images/border-circle-5.png'
        }
    },
    methods: {
        openImage () {
            this.visiblePopup = !this.visiblePopup
        }
    },
    props: {
        disableBorder: {
            type: Boolean,
            required: false 
        },
        image: {
            type: String,
            required: true
        },
        cover: {
            type: String,
            required: false
        }
    }
}
</script>