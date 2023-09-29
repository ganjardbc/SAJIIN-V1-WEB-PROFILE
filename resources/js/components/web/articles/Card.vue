<template>
    <div id="App" class="display-flex display-mobile wrap">
        <div 
            v-for="(dt, index) in datas" 
            :key="index" 
            class="width width-row-3"
        >
            <div style="margin: 15px;">
                <div class="card box-shadow border-radius" style="width: 100%; padding: 0; margin: 0;">
                    <div style="margin-bottom: 20px;">
                        <router-link :to="{name: 'article-public', params: {id: dt.article_id}}">
                            <div class="image image-half-padding" style="border-radius: 0;">
                                <img :src="dt.image" alt="">
                            </div>
                        </router-link>
                    </div>
                    <div style="padding: 0 20px; width: calc(100% - 40px);">
                        <div class="fonts fonts-16px semibold black" style="margin-bottom: 5px;">{{ dt.title }}</div>
                        <div class="display-flex" style="margin-bottom: 20px;">
                            <div class="card-capsule todo">{{ dt.created_at | moment('DD MMMM YYYY') }}</div>
                        </div>
                        <div class="display-flex space-between">
                            <router-link :to="{name: 'article-public', params: {id: dt.article_id}}" class="btn btn-main-reverse" style="padding-left: 0; padding-right: 0; border-radius: 0;">
                                Selengkapnya <i class="icn fa fa-1x fa-arrow-right" />
                            </router-link>
                        </div>
                    </div>
                    <div style="padding-bottom: 20px;"></div>
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
            required: true
        }
    },
    data () {
        return {
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