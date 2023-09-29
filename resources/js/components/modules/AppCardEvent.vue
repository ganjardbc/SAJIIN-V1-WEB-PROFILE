<template>
    <div id="App" class="display-flex center wrap" style="padding-top: 15px;">
        <div v-for="(dt, i) in data" :key="i" :class="defaultColumn">
            <div :class="`padding padding-15-px ${enableAnimation && 'theme-invitation-animate'}`">
                <div class="card bg-white box-shadow border-radius content-center" :style="`overflow: unset; padding-top: 80px; padding-bottom: 60px; margin-top: 40px; border-radius: ${customBorderRadius ? customBorderRadius : '12px'};`">
                    <div style="position: absolute; top: -40px; left: 0; width: 100%; margin: auto;">
                        <div class="image image-80px image-center image-circle box-shadow bg-white">
                            <i 
                                :class="`post-middle-absolute ${customIcon ? customIcon : 'fa fa-lg fa-heart'}`"
                                :style="`color: ${customMainColor ? customMainColor : '#66806A'};`"></i>
                        </div>
                    </div>
                    <h2 
                        :class="`fonts ${customMainFontSize ? customMainFontSize : 'fonts-24'} black ${customMainFont ? customMainFont : 'RoxboroughCF'} ${customMainFontWeight ? customMainFontWeight : 'weight-bold'}`" 
                        :style="`color: ${customMainColor ? customMainColor : '#66806A'}; margin-bottom: 15px;`">{{ dt.title }}</h2>
                    <div 
                        v-if="dt.description" 
                        :class="`fonts ${customPrimaryFontSize ? customPrimaryFontSize : 'fonts-12'} black ${customPrimaryFont ? customPrimaryFont : ''}`"
                        style="margin-bottom: 42px;">
                        {{ dt.description }}
                    </div>
                    <div 
                        v-if="dt.address" 
                        :class="`fonts ${customPrimaryFontSize ? customPrimaryFontSize : 'fonts-12'} black ${customPrimaryFont ? customPrimaryFont : ''}`"
                        style="margin-bottom: 42px;">
                        {{ dt.address }}
                    </div>
                    <div 
                        v-if="dt.date" 
                        :class="`fonts ${customPrimaryFontSize ? customPrimaryFontSize : 'fonts-12'} black ${customPrimaryFont ? customPrimaryFont : ''}`"
                        style="margin-bottom: 15px;">
                        {{ dt.date | moment("dddd, Do MMMM YYYY") }}
                    </div>
                    <div 
                        v-if="dt.time"
                        :class="`fonts ${customMainFontSize ? customMainFontSize : 'fonts-18'} black ${customMainFont ? customMainFont : 'RoxboroughCF'} ${customMainFontWeight ? customMainFontWeight : 'weight-bold'}`">
                        {{ dt.time }}
                    </div>
                    <div 
                        v-if="dt.time_zone" 
                        :class="`fonts ${customPrimaryFontSize ? customPrimaryFontSize : 'fonts-12'} black ${customPrimaryFont ? customPrimaryFont : ''}`"
                        style="margin-top: 10px;">
                        {{ dt.time_zone }}
                    </div>
                    <div 
                        v-if="dt.streaming_link"
                        class="display-flex center">
                        <a 
                            :href="dt.streaming_link" 
                            target="_blank" 
                            class="btn btn-main"
                            :style="`
                                background-color: ${customMainColor ? customMainColor : '#66806A'}; 
                                border-color: ${customMainColor ? customMainColor : '#66806A'}; 
                                color: #fff;
                                margin-top: 42px;
                            `">
                            View Live Streaming <i class="icn icn-right fab fa-lw fa-youtube" />
                        </a>
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
        enableEnglish: {
            default: false,
        },
        customMainColor: {
            default: null,
        },
        customMainFont: {
            default: null,
        },
        customPrimaryFont: {
            default: null 
        },
        customMainFontSize: {
            default: null,
        },
        customPrimaryFontSize: {
            default: null 
        },
        customMainFontWeight: {
            default: null,
        },
        customPrimaryFontWeight: {
            default: null 
        },
        customBorderRadius: {
            default: null,
        },
        column: {
            default: null,
        },
        customIcon: {
            default: null,
        }
    },
    computed: {
        defaultColumn () {
            let column = 'width width-row-2'
            switch (this.column) {
                case '1':
                    column = 'width width-row-1'
                    break
                case '2':
                    column = 'width width-row-2'
                    break
                case '4':
                    column = 'width width-row-3'
                    break
                case '5':
                    column = 'width width-row-5'
                    break
                default:
                    column = 'width width-row-2'
                    break
            }
            return column
        }
    },
    created () {
        if (this.enableEnglish) {
            this.$moment.locale('en-in')
        } else {
            this.$moment.locale('id')
        }
    }
}
</script>