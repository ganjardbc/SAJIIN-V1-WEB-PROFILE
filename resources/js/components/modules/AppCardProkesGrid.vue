<template>
    <div id="App">
        <div class="display-flex row display-mobile" style="text-align: center; width: 100%;">
            <div v-for="(dt, i) in prokes" :key="i" class="width width-row-4">
                <div :class="`padding padding-15-px ${enableAnimation && 'theme-invitation-animate'}`">
                    <div class="card bg-white box-shadow content-center" :style="`border-radius: ${customBorderRadius ? customBorderRadius : '0'}; overflow: unset; padding-top: 20px; padding-bottom: 20px;`">
                        <div class="image image-65px image-center image-circle" :style="`margin-bottom: 20px; background-color: ${customBackground ? customBackground : '#FACC48'};`">
                            <i :class="'post-middle-absolute ' + dt.icon" style="font-size: 38px; color: #1A1507;" />
                        </div>
                        <div :class="`fonts fonts-11 black ${customMainFont ? customMainFont : ''}`">
                            {{ enableEnglish ? dt.englishTitle : dt.title }}
                        </div>
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
            prokes: [
                {title: 'Memakai Masker', englishTitle: 'Wearing a Mask', icon: 'fa fa-head-side-mask'},
                {title: 'Hindari Berjabat Tangan', englishTitle: 'Avoid Shaking Hands', icon: 'fa fa-lg fa-handshake-slash'},
                {title: 'Menjaga Jarak', englishTitle: 'Keep the Distance', icon: 'fa fa-lg fa-people-arrows'},
                {title: 'Mencuci Tangan', englishTitle: 'Washing Hands', icon: 'fa fa-lg fa-hands-wash'}
            ]
        }
    },
    props: {
        enableAnimation: {
            default: false 
        },
        enableEnglish: {
            default: false 
        },
        customBackground: {
            default: null,
        },
        customBorderRadius: {
            default: null,
        },
        customMainFont: {
            default: null,
        }
    }
}
</script>