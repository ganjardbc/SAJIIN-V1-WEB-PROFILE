<template>
    <div id="Preview" class="main-screen">
        <div class="self-padding" style="padding-bottom: 0;">
            <div class="space">
                <h2 class="fonts fonts-32px align-center bold black no-line-height theme-pricing-animate" style="margin-bottom: 15px;">
                    Tampilan aplikasi dari Saji-in POS
                </h2>
                <p class="fonts fonts-16px align-center grey theme-pricing-animate">
                    Berikut tampilan dari aplikasi saji-in untuk owner, cashier, kitchen dan customer.
                </p>
            </div>
        </div>
        <div class="width width-78 width-mobile width-center">
            <div class="padding padding-left-30px padding-right-30px">
                <carousel 
                    :per-page="1" 
                    :mouse-drag="false" 
                    :centerMode="true" 
                    :loop="true" 
                    :autoplay="false" 
                    :speed="2000" 
                    :autoplayTimeout="7000" 
                    :navigationEnabled="true"
                    :paginationEnabled="true"
                    :paginationPadding="5"
                    :paginationSize="15" 
                    :paginationColor="'#ededf1'" 
                    :paginationActiveColor="'#FB3640'"
                    :paginationPosition="'bottom'">
                    <slide v-for="(dt, i) in data" :key="i">
                        <div class="padding padding-15px">
                            <div class="width width-60 width-mobile width-center">
                                <div class="card bg-white box-shadow">
                                    <div class="image image-padding" :style="`background-image: url(${dt.image});`"></div>
                                </div>
                            </div>
                        </div>
                    </slide>
                </carousel>
            </div>
        </div>
    </div>
</template>
<script>
import { Carousel, Slide } from 'vue-carousel'
import cover from '../../../../img/introduction.png'

export default {
    name: 'Preview',
    data() {
        return {
            data: [
                {image: cover, description: ''},
                {image: cover, description: ''},
                {image: cover, description: ''},
                {image: cover, description: ''},
            ]
        }
    },
    components: {
        Carousel,
        Slide,
    }
}
</script>