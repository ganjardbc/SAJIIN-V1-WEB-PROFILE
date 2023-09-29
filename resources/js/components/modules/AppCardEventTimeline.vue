<template>
    <div class="theme-container">
        <!-- ${i % 2 > 0 ? 'fadeInLeft' : 'fadeInRight'} -->
        <!-- ${i % 2 > 0 ? 'fadeInRight' : 'fadeInLeft'} -->
        <div 
            v-for="(dt, i) in data" :key="i" 
            :class="'theme-ceremony ' + (i % 2 === 0 ? 'reverse' : '')">
            <div class="ceremony-cover">
                <div 
                    :class="`ceremony-icon ${enableAnimation && 'theme-invitation-animate'}`">
                    <div class="icn image image-80px image-center image-circle box-shadow bg-white">
                        <i 
                            :class="`post-middle-absolute ${customIcon ? customIcon : 'fa fa-lg fa-heart'}`" 
                            :style="`color: ${customMainColor ? customMainColor : '#5C786D'}; font-size: 24px;`"></i>
                    </div>
                </div>
            </div>
            <div class="ceremony-info">
                <div class="width width-full">
                    <div :class="`ceremony-title ${enableAnimation && 'theme-invitation-animate'}`">
                        <div style="padding-left: 15px; padding-right: 15px;">
                            <h1 
                                :class="`fonts fonts-24 black semibold ${customMainFont ? customMainFont : 'RoxboroughCF'}`" 
                                :style="`color: ${customMainColor ? customMainColor : '#5C786D'};`">{{ dt.title }}</h1>
                        </div>
                    </div>
                    <div 
                        v-if="dt.address"
                        :class="`ceremony-address ${enableAnimation && 'theme-invitation-animate'}`" 
                        style="padding-top: 30px; padding-bottom: 30px;">
                        <div class="width width-70 width-center width-mobile">
                            <div class="fonts fonts-12 black">{{ dt.address }}</div>
                        </div>
                    </div>
                    <div class="ceremony-address">
                        <div 
                            v-if="dt.date"
                            :class="`fonts fonts-12 black align-center ${enableAnimation && 'theme-invitation-animate'}`">
                            {{ dt.date | moment("dddd, Do MMMM YYYY") }}
                        </div>
                        <div 
                            v-if="dt.time"
                            :class="`${enableAnimation && 'theme-invitation-animate'}`">
                            <b :class="`fonts fonts-18 black align-center semibold ${customMainFont ? customMainFont : 'RoxboroughCF'}`">
                                {{ dt.time }}
                            </b>
                        </div>
                        <div 
                            v-if="dt.time_zone"  
                            :class="`${enableAnimation && 'theme-invitation-animate'}`">
                            <div class="fonts fonts-12 black align-center">
                                {{ dt.time_zone }}
                            </div>
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
            default: false,
        },
        customMainColor: {
            default: null,
        },
        customMainFont: {
            default: null,
        },
        customBorderRadius: {
            default: null,
        },
        customIcon: {
            default: null,
        }
    },
}
</script>