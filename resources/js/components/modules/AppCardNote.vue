<template>
    <div id="App">
        <div class="width width-100">
            <div :class="`padding padding-15-px ${enableAnimation && 'theme-invitation-animate'}`">
                <div 
                    class="card bg-white box-shadow content-center" 
                    :style="`border-radius: ${customBorderRadius ? customBorderRadius : '0'}; overflow: unset; padding-top: 20px; padding-bottom: 20px;`">
                    <div 
                        class="image image-65px image-center image-circle" 
                        :style="`margin-bottom: 20px; background-color: ${customBackground ? customBackground : '#FACC48'};`">
                        <i 
                            :class="`post-middle-absolute ${icon ? icon : 'fa fa-lg fa-broadcast-tower'}`" 
                            style="font-size: 38px; color: #1A1507;" />
                    </div>
                    <div class="fonts fonts-11 black">
                        {{ text }}
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
        return {}
    },
    props: {
        icon: {
            default: null,
        },
        text: {
            default: null,
        },
        enableAnimation: {
            default: false,
        },
        enableEnglish: {
            default: false,
        },
        customBackground: {
            default: null,
        },
        customBorderRadius: {
            default: null,
        }
    }
}
</script>