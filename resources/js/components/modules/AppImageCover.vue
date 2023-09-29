<template>
    <div id="App">
        <div 
            class="cover" 
            :style="`
                background-image: url(${image}); 
                cursor: pointer; 
                borderRadius: ${disableBorderRadius ? '0' : '8px'};
                margin: ${disableMargin ? '0' : '5px'};
                width: ${disableMargin ? '100%' : 'calc(100% - 10px)'};
                height: ${disableMargin ? '100%' : 'calc(100% - 10px)'};
            `" 
            @click="openImage" 
            title="click to open image"></div>

        <div 
            v-if="visiblePopup" 
            class="display-popup" 
            @click="openImage" 
            :style="`background-color: ${backgroundColor ? backgroundColor : 'rgba(0, 0, 0, 0.34)'};`">
            <div class="width width-600-px width-mobile post-middle">
                <div style="padding: 15px;">
                    <div class="image image-padding bg-grey" style="border-radius: 0;;">
                        <img class="img" :src="cover ? cover : image" alt="">
                    </div>
                    <div style="position: absolute; right: 0; top: 0;">
                        <button class="btn btn-small-icon btn-black" style="margin: auto; border-radius: 100%;">
                            <i class="fa fa-lg fa-times"></i>
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
            visiblePopup: false
        }
    },
    methods: {
        openImage () {
            this.visiblePopup = !this.visiblePopup
        }
    },
    props: {
        disableBorderRadius: {
            type: Boolean,
            required: false
        },
        disableMargin: {
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
        },
        backgroundColor: {
            default: null
        }
    }
}
</script>