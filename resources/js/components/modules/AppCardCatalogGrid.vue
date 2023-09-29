<template>
    <div id="AppCardGrid" class="display-flex display-mobile wrap">
        <div 
            v-for="(dt, index) in datas" 
            :key="index" 
            class="width width-row-4"
        >
            <div class="card box-shadow theme-catalogs-animate" style="padding: 0; margin: 20px 20px;">
                <div class="theme-catalogs-animate" style="margin-bottom: 20px;">
                    <router-link :to="dt.subtitle" target="_blank">
                        <div style="width: 100%; padding-bottom: 100%; border-radius: 0; overflow: hidden;">
                            <img :src="articleImageThumbnailUrl + dt.image" alt="" class="post-center-absolute" style="width: 100%; position: absolute;">
                        </div>
                    </router-link>
                </div>
                <div style="padding: 0 20px; width: calc(100% - 40px);">
                    <div class="fonts semibold black theme-catalogs-animate" style="text-align: center; margin-top: 0;">{{ dt.title }}</div>
                    <div class="fonts fonts-13px grey theme-catalogs-animate" style="text-align: center; margin-top: 5px;">{{ dt.description }}</div>
                    <div class="display-flex space-between theme-catalogs-animate" style="margin-top: 10px;">
                        <a 
                            :href="'https://api.whatsapp.com/send?phone=+62-8515-5377-009'" 
                            target="_blank" 
                            class="btn btn-main btn-full">
                            <i class="icn icn-left fa fa-lw fa-shopping-cart" /> Pesan Ini 
                        </a>
                    </div>
                </div>
                <div style="padding-bottom: 20px;"></div>
            </div>
        </div>
    </div>
</template>

<script>
import AppWrapper from './AppWrapper'
import AppButton from './AppButton'
import AppText from './AppText'
import icon from '../../../img/icon.png'

export default {
    name: 'AppCardGrid',
    components: {
        AppWrapper,
        AppButton,
        AppText
    },
    props: {
        data: {
            required: true
        }
    },
    // mounted() {
    //     console.log('data', this.data)
    // },
    data () {
        return {
            icon: icon,
            datas: this.data
        }
    },
    watch: {
        data: function (props, prevProps) {
            if (props) {
                this.datas = props
            } else {
                this.datas = []
            }
        }
    }
}
</script>