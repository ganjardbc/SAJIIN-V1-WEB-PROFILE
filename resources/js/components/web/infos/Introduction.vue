<template>
    <div id="Introduction" class="main-screen">
        <div class="self-padding" style="padding-bottom: 0;">
            <div class="space space-center">
                <h2 class="fonts fonts-32px align-center bold black no-line-height theme-home-animate" style="margin-bottom: 15px;">
                    Memperkenalkan Saji-in POS
                </h2>
                <p class="fonts fonts-16px grey">
                    Kelola dan pantau seluruh pesanan dalam 1 aplikasi
                </p>
            </div>
        </div>
        <div class="padding padding-left-15px padding-right-15px padding-bottom-20px">
            <div class="width width-80 width-center width-mobile">
                <div 
                    class="image image-half-padding" 
                    :style="`background-image: url(${cover}); cursor: pointer;`"
                    @click="onOpenCloseVideo">
                    <div class="post-middle-absolute">
                        <div class="image image-80px image-circle bg-main">
                            <i class="post-middle-absolute fonts big white fa fa-lg fa-play"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <AppPopupForm 
            v-if="visiblePopup"
            title="Saji-in Overview"
            :onClose="onOpenCloseVideo">
            <div class="width width-100">
                <AppCardVideo data="https://www.youtube.com/watch?v=HCDVN7DCzYE" />
                <div class="padding padding-top-20px">
                    <router-link :to="{name: 'how-to-orders'}" class="btn btn-main">
                        Daftarkan Toko
                    </router-link>
                </div>
            </div>
        </AppPopupForm>
    </div>
</template>
<script>
import cover from '../../../../img/introduction.png'
import AppPopupForm from '../../modules/AppPopupForm'
import AppCardVideo from '../../modules/AppCardVideo'

export default {
    name: 'Introduction',
    components: {
        AppPopupForm,
        AppCardVideo
    },
    data() {
        return {
            cover: cover,
            visiblePopup: false,
        }
    },
    methods: {
        onOpenCloseVideo () {
            this.visiblePopup = !this.visiblePopup
        }
    }
}
</script>