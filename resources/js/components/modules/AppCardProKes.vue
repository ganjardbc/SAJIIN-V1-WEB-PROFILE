<template>
    <div id="App">
        <div v-if="visiblePopup" class="display-popup">
            <div class="card-alert big box-shadow post-middle" style="padding: 0;">
                <div class="display-flex space-between align-center" style="padding: 15px;">
                    <div>
                        <div class="fonts fonts-11 semibold">Peringatan</div>
                    </div>
                    <button class="btn btn-icon btn-white" @click="onOpen">
                        <i class="fa fa-lg fa-times"></i>
                    </button>
                </div>
                <div style="padding: 15px; max-height: calc(100vh - 180px); overflow-y: auto;">
                    <div class="content-center">
                        <div class="fonts fonts-10 black">Acara ini dilaksanakan dengan menerapkan</div>
                        <div class="fonts fonts-16 black semibold">PROTOKOL KESEHATAN</div>
                        <div class="fonts fonts-10 black">Sebagai berikut:</div>
                    </div>
                    <div style="padding-top: 30px; padding-bottom: 30px;" class="display-flex wrap">
                        <div v-for="(dt, i) in data" :key="i" style="width: calc(100% / 3)">
                            <div style="padding: 10px;" class="content-center">
                                <div class="image image-65px image-center image-circle" :style="`margin-bottom: 5px; background-color: ${customBackground ? customBackground : '#FACC48'};`">
                                    <i :class="'post-middle-absolute ' + dt.cover" style="font-size: 38px; color: #1A1507;" />
                                </div>
                                <div class="fonts fonts-9 black">{{ dt.title }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="content-center">
                        <div class="fonts fonts-10 black" style="margin-bottom: 15px;">Tanpa mengurangi rasa hormat demi mengurangi penyebaran pandemi, mohon untuk tetap mengikuti protokol kesehatan yang berlaku.</div>
                        <div class="fonts fonts-9 black" style="margin-bottom: 15px;">Peringatan ini akan tertutup otomatis dalam 15 detik.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import prokes from '../../../img/prokes3M.jpeg'

export default {
    name: 'App',
    data () {
        return {
            visiblePopup: false,
            prokes: prokes,
            data: [
                {cover: 'fa fa-head-side-mask', title: 'Memakai Masker'},
                {cover: 'fa fa-lg fa-hands-wash', title: 'Mencuci Tangan'},
                {cover: 'fa fa-lg fa-people-arrows', title: 'Menjaga Jarak'},
                {cover: 'fa fa-lg fa-handshake-slash', title: 'Tidak Berjabat Tangan'},
                {cover: 'fa fa-lg fa-temperature-high', title: 'Mengecek Suhu Tubuh'},
                {cover: 'fa fa-lg fa-pump-soap', title: 'Membawa Handsanitizer'}
            ]
        }
    },
    mounted () {
        this.visiblePopup = true 
        setTimeout(() => {
            this.visiblePopup = false
        }, 15000)
    },
    methods: {
        onOpen () {
            this.visiblePopup = !this.visiblePopup
        }
    },
    props: {
        customBackground: {
            default: null,
        }
    }
}
</script>