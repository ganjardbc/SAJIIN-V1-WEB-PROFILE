<template>
    <div id="App">
        <div class="display-flex row center wrap" style="text-align: center; width: 100%;">
            <div v-for="(dt, i) in data" :key="i" class="width width-row-5 width-row-mobile-2">
                <div :class="`padding padding-15-px ${enableAnimation && 'theme-invitation-animate'}`">
                    <div 
                        class="card bg-white box-shadow content-center" 
                        :style="`
                            border-radius: ${customBorderRadius ? customBorderRadius : '0'}; 
                            overflow: unset; 
                            padding-top: 20px; 
                            padding-bottom: 20px;
                        `">
                        <div 
                            class="image image-half-padding" 
                            :style="`
                                margin-bottom: 20px; 
                                background-size: contain; 
                                background-image: url(${specialthankImageThumbnailUrl + dt.image}); 
                                background-color: ${customBackground ? customBackground : '#fff'};
                            `">
                        </div>
                        <div :class="`fonts fonts-11 black ${customMainFont ? customMainFont : ''}`">
                            {{ dt.name }}
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
    props: {
        data: {
            default: null,
        },
        enableAnimation: {
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
    },
}
</script>