<template>
     <div id="App" class="display-popup">
        <div class="post-middle-absolute width width-400px width-mobile">
            <div class="padding padding-15px">
                <div class="card box-shadow bg-white">
                    <div class="display-flex space-between align-center">
                        <div class="fonts fonts-11 semibold black">QR-Code</div>
                        <button class="btn btn-white btn-icon" @click="onClose">
                            <i class="fa fa-lg fa-times"></i>
                        </button>
                    </div>
                    <div class="margin margin-top-15px margin-bottom-15px">
                        <div class="content-center" style="width: 300px; margin: auto; padding-bottom: 15px;">
                            <div class="image image-padding" style="background-color: #f5f5f5;">
                                <VueQrcode :value="code" />
                            </div>
                        </div>
                        <div v-if="code" class="content-center" style="padding-bottom: 10px;">
                            <div class="fonts fonts-9 grey">{{ code }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueQrcode from 'vue-qrcode'
import AppPopupForm from './AppPopupForm'

export default {
    name: 'App',
    props: {
        code: null,
    },
    components: {
        VueQrcode,
        AppPopupForm,
    },
    methods: {
        onClose () {
            this.$emit('onClose')
        }
    }
}
</script>
