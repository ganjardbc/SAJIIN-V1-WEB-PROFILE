<template>
    <div :class="isListView ? '' : 'display-flex wrap'" id="AppCardGrid">
        <div 
            v-for="(dt, index) in datas" 
            :key="index" 
            :style="'position: relative; padding: 0; ' + (isListView ? 'width: 100%;' : 'width: calc(100% / 3);')"
        >
            <div :class="'card box-shadow ' + (isListView && 'mobile-grid')" style="padding: 0; margin: 0 20px; margin-top: 30px;">
                <div class="left">
                    <router-link :to="{name: 'product', params: {id: dt.product_id}}">
                        <div class="cover">
                            <img :src="dt.image" alt="product" class="post-center" style="width: 100%;">
                        </div>
                    </router-link>
                </div>
                <div class="right">
                    <div style="position: relative; width: 100%; margin-bottom: 15px;">
                        <router-link :to="{name: 'product', params: {id: dt.product_id}}" class="fonts fonts-16px semibold black" style="margin-top: 0;">
                            {{ dt.title }}
                        </router-link>
                        <div class="fonts fonts-13px grey" style="margin-top: 5px;">{{ dt.category }}</div>
                        <div class="fonts fonts-16px semibold black" style="margin-top: 5px;">Rp {{ dt.price }}</div>
                    </div>
                    <div class="display-flex space-between">
                        <div class="display-flex">
                            <div :class="dt.is_available ? 'card-capsule active' : 'card-capsule'" style="margin-top: 4px; margin-right: 10px;">{{ dt.available }}</div>
                            <AppLikeButton :productID.sync="dt.id" />
                        </div>
                        <router-link :to="{name: 'product', params: {id: dt.product_id}}" class="btn btn-main-reverse" style="padding-left: 0; padding-right: 0">
                            View product <i class="icn fa fa-1x fa-arrow-right" />
                        </router-link>
                    </div>
                </div>
                <div style="padding-bottom: 20px;"></div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
import AppWrapper from './AppWrapper'
import AppButton from './AppButton'
import AppText from './AppText'
import AppLikeButton from './AppLikeButton'
import icon from '../../../img/icon.png'

export default {
    name: 'AppCardGrid',
    data () {
        return {
            icon: icon,
            datas: this.data
        }
    },
    components: {
        AppLikeButton,
        AppWrapper,
        AppButton,
        AppText
    },
    props: {
        isListView: {
            type: Boolean,
            required: false
        },
        data: {
            required: true
        }
    },
    // mounted() {
    //     console.log('data', this.data)
    // },
    methods: {
        ...mapActions({
            setToast: 'toast/setToast'
        }),
        makeToast (title) {
            const payload = {
                visible: true,
                title: title
            }
            this.setToast(payload)
        },
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