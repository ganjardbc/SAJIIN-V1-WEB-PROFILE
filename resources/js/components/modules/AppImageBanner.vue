<template>
    <div 
        id="App" 
        :class="'theme-border-banner'"
        :style="`${position === 'top' ? 'top: 0 !important;' : 'bottom: 0 !important;'}`" >
        <img :src="customImage ? customImage : image" alt="">
    </div>
</template>
<script>

export default {
    name: 'App',
    data () {
        return {
            image: '/images/flower-banner-top-5.jpeg'
        }
    },
    props: {
        customImage: {
            default: null,
        },
        position: {
            default: null,
        }
    }
}
</script>