<template>
    <div id="App">
        <div class="display-flex row center wrap" style="text-align: center; width: 100%;">
            <div v-for="(dt, i) in data" :key="i" class="width width-row-3 width-mobile">
                <div :class="`padding padding-15-px ${enableAnimation && 'theme-invitation-animate'}`">
                    <div 
                        class="card bg-white box-shadow content-center" 
                        :style="`border-radius: ${customBorderRadius ? customBorderRadius : '0'}; overflow: unset; padding-top: 20px; padding-bottom: 20px;`">
                        <div 
                            class="image image-half-padding" 
                            :style="`margin-bottom: 20px; background-size: contain; background-image: url(${commentImageThumbnailUrl + dt.image}); background-color: ${customBackground ? customBackground : '#fff'};`">
                        </div>
                        <div class="fonts fonts-11 black">
                            {{ dt.name }}
                        </div>
                        <div class="display-flex column center">
                            <div class="fonts fonts-12 black semibold" :id="`target-code-${i}`" style="margin-bottom: 10px; word-wrap: break-word;">{{ dt.comment }}</div>
                            <button class="btn btn-sekunder" @click="copyDigitalCode(`target-code-${i}`)">
                                <i class="icn icn-left far fa-lg fa-credit-card"></i> Salin Nomor
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions } from 'vuex'

export default {
    name: 'App',
    props: {
        data: {
            default: null,
        },
        enableAnimation: {
            default: false,
        },
        customBackground: {
            default: null,
        },
        customBorderRadius: {
            default: null,
        },
    },
    methods: {
        ...mapActions({
            setToast: 'toast/setToast',
        }),
        makeToast (title) {
            const payload = {
                visible: true,
                title: title
            }
            this.setToast(payload)
        },
        copyDigitalCode (id) {
            const str = document.getElementById(id).innerHTML;
            const el = document.createElement('input');
            el.value = str;
            document.body.appendChild(el);
            el.select();

            try {
                var successful = document.execCommand('copy')
                var msg = successful ? 'berhasil' : 'tidak dapat'
                this.makeToast('Nomor ' + msg + ' di salin')
            } catch (err) {
                this.makeToast('Oops, nomor tidak dapat di salin')
            }

            document.body.removeChild(el)
        },
    }
}
</script>