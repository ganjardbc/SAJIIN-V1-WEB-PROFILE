<template>
    <div id="AppCardGrid" class="display-flex display-mobile wrap">
        <div 
            v-for="(dt, index) in datas" 
            :key="index" 
            class="width width-row-3"
        >
            <div class="card box-shadow border-radius" style="padding: 0; margin: 20px 20px;">
                <div style="margin-bottom: 20px;">
                    <div style="width: 100%; height: 240px; border-radius: 0; overflow: hidden;">
                        <img :src="dt.image" alt="" class="post-center" style="width: 100%;">
                    </div>
                </div>
                <div style="padding: 0 20px; width: calc(100% - 40px);">
                    <div class="fonts semibold black">{{ dt.title }}</div>
                    <div class="fonts fonts-13px grey overflow-ellipsis" style="margin-bottom: 40px;">{{ dt.description }}</div>
                    <div class="display-flex space-between" style="margin-top: 10px;">
                        <router-link :to="{name: 'article', params: {id: dt.article_id}}" class="btn btn-main-reverse" style="padding-left: 0; padding-right: 0; border-radius: 0;">
                            Selengkapnya <i class="icn fa fa-1x fa-arrow-right" />
                        </router-link>
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