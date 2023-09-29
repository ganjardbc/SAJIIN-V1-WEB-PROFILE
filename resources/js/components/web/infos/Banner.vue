<template>
    <div id="Banner">
        <div class="banner">
            <div class="banner-container banner-flex">
                <div id="header-right-info" class="right wrapper wrapper-right theme-home-animate">
                    <div class="image image-padding" :style="`background-color: #fff;`">
                        <img :src="cover" alt="saji-in" class="post-center" style="width: 100%;">
                    </div>
                </div>
                <div id="header-left-info" class="left">
                    <div class="post-top post-mobile-none">
                        <div style="width: 100%;" id="header-left-info">
                            <div class="width width-100" style="margin-bottom: 15px;">
                                <div class="fonts fonts-16px main semibold theme-home-animate" style="margin-bottom: 5px;">
                                    Saji-in POS
                                </div>
                                <h1 class="fonts fonts-42px bold black no-line-height theme-home-animate">
                                    Permudah Pesanan dan <br /> Tingkatkan Pelayanan <br /> dengan Saji-in
                                </h1>
                            </div>
                            <div class="width width-70 width-mobile" style="margin-bottom: 40px;">
                                <p class="fonts fonts-16px grey theme-home-animate">
                                    Aplikasi sederhana yang menyediakan kemudahan pengelolaan pesanan dan peningkatan performa pelayanan bagi pengusaha F&B.
                                </p>
                            </div>
                        </div>
                        <div class="theme-home-animate" style="width: 100%;">
                            <div class="display-flex">
                                <!-- <button class="btn btn-sekunder btn-icon" style="margin-left: 0; margin-right: 10px;" @click="onOpenCloseVide">
                                    <i class="icn fa fa-lg fa-play"></i>
                                </button> -->
                                <router-link :to="{name: 'how-to-orders'}" class="btn btn-big btn-main" style="margin-left: 0; margin-right: 10px;">
                                    Coba Gratis
                                </router-link>
                                <router-link :to="{name: 'how-to-orders'}" class="btn btn-big btn-main-reverse with-border" style="margin-left: 0; margin-right: 10px;">
                                    Request Demo
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <AppPopupForm 
            v-if="visiblePopup"
            title="Saji-in Overview"
            :onClose="onOpenCloseVide">
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
import cover from '../../../../img/banner-1.png'
import AppPopupForm from '../../modules/AppPopupForm'
import AppCardVideo from '../../modules/AppCardVideo'

export default {
    name: 'Banner',
    components: {
        AppPopupForm,
        AppCardVideo
    },
    data () {
        return {
            cover,
            visiblePopup: false,
        }
    },
    methods: {
        onOpenCloseVide () {
            this.visiblePopup = !this.visiblePopup
        }
    }
}
</script>