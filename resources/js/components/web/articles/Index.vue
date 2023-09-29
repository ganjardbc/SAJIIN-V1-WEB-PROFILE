<template>
    <div id="AppArticle" class="main-screen" style="padding-top: 0;">
        <AppLoader v-if="visibleLoader" style="padding-top: 80px;" />

        <div v-if="!visibleLoader">
            <div class="small-screen box-shadow" style="background-color: #fff; position: relative; top: 0; margin-bottom: 40px;">
                <div class="image image-half-padding" style="border-radius: 0; background-color: #fff;">
                    <img :src="data && data.cover" alt="" class="post-center" style="width: 100%;">
                </div>
                <div class="padding padding-30-px">
                    <h1 class="fonts fonts-38px semibold black" style="margin-bottom: 20px;">{{ data && data.title }}</h1>
                    <i class="fonts fonts-14px grey" style="margin: 20px 0;">{{ data && data.description }}</i>
                    <p class="fonts fonts-16px black" style="margin: 20px 0;" v-html="data && data.content"></p>
                    <div class="display-flex" style="margin-bottom: 20px;">
                        <div class="card-capsule todo">{{ data && data.created_at | moment('DD MMMM YYYY') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import AppWrapper from '../../modules/AppWrapper'
import AppButton from '../../modules/AppButton'
import AppText from '../../modules/AppText'
import AppLoader from '../../modules/AppLoader'

export default {
    name: 'product',
    data () {
        return {
            visibleLoader: false,
            data: null 
        }
    },
    components: {
        AppLoader,
        AppWrapper,
        AppButton,
        AppText
    },
    mounted () {
        this.getArticle()
    },
    methods: {
        async getArticle () {
            this.visibleLoader = true 

            const id = this.$route.params.id
            const payload = {
                article_id: id
            }

            const rest = await axios.post('/api/public/articleByID', payload)

            if (rest && rest.status === 200) {
                const data = rest.data.data
                this.data = {
                    ...data,
                    cover: '/contents/articles/covers/' + data.image,
                    thumbnail: '/contents/articles/thumbnails/' + data.image
                }
                this.visibleLoader = false 
            } else {
                this.visibleLoader = false 
            }
        },
    },
}
</script>