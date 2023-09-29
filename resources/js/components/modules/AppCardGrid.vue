<template>
    <div 
        id="AppCardGrid" 
        class="display-flex nowrap space-bettween"
        style="width: 100%; background-color: #fff;">
        <div 
            v-for="(dt, index) in datas" 
            :key="index" 
            class="card" 
            style="margin-left: 5px; margin-right: 5px; text-align: center;"
        >
            <div class="display-flexs nowrap" style="padding-top: 20px; padding-bottom: 20px;">
                <div style="width: 80px; margin: auto; margin-bottom: 15px;">
                    <div style="width: 80px; height: 80px; border-radius: 5px; margin: auto; overflow: hidden;">
                        <img :src="dt.image" :alt="dt.title" class="post-center" style="width: 100%;">
                    </div>
                </div>
                <div style="width: 100%;">
                    <div class="fonts fonts-14px semibold black" style="margin-bottom: 5px;">{{ dt.title }}</div>
                    <div class="fonts fonts-13px grey">{{ dt.description }}</div>
                </div>
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
        data: function(props, prevProps) {
            if (props) {
                this.datas = props
            } else {
                this.datas = []
            }
        }
    }
}
</script>