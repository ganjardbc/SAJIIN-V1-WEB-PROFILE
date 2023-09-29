<template>
    <div id="App">
        <carousel 
            :per-page="1" 
            :adjustableHeight="false"
            :mouse-drag="false" 
            :centerMode="true" 
            :loop="true" 
            :autoplay="true" 
            :speed="2000" 
            :autoplayTimeout="7000" 
            :paginationSize="15"
            :navigationEnabled="true"
            :paginationEnabled="true" 
            :paginationActiveColor="paginationActiveColor ? paginationActiveColor : '#94A986'"
            :paginationColor="paginationColor ? paginationColor : '#555'" 
            :paginationPosition="paginationPosition ? paginationPosition : '#ff0000'"
            :navigationPrevLabel="`<i class='fa fa-lg fa-chevron-left' />`"
            :navigationNextLabel="`<i class='fa fa-lg fa-chevron-right' />`"
        >
            <slide v-for="(dt, i) in data" :key="i">
                <div class="theme-image small">
                    <img class="img box-shadow border-radius" :src="(dt.image ? (galleryImageCoverUrl + dt.image) : '')" alt="">
                </div>
            </slide>
        </carousel>
    </div>
</template>
<script>
import { Carousel, Slide } from 'vue-carousel'

export default {
    name: 'App',
    components: {
        Carousel,
        Slide,
    },
    props: {
        data: {
            required: true 
        },
        paginationActiveColor: {
            default: null 
        },
        paginationColor: {
            default: null 
        },
        paginationPosition: {
            default: null
        }
    },
}
</script>