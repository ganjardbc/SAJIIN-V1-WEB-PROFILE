<template>
    <div id="App">
        <AppBanner />
        <AppTryItForFree />
        <AppIntroduction />
        <AppFeatures />
        <AppDemoVideo />
        <AppPreview />
        <AppPricing />
        <AppSmallrticle />
        <AppSampleOrders />
        <AppConsultation />
    </div>
</template>

<script>
import axios from 'axios'
import AppBanner from './infos/Banner'
import AppIntroduction from './infos/Introduction'
import AppFeatures from './infos/Features'
import AppPricing from './infos/Pricing'
import AppDemoVideo from './infos/DemoVideo'
import AppPreview from './infos/Preview'
import AppTryItForFree from './infos/TryItForFree'
import AppSampleOrders from './infos/SampleOrders'
import AppConsultation from './infos/Consultation'
import AppSmallrticle from './articles/Small'

export default {
    name: 'App',
    metaInfo: {
        title: 'Saji-in',
        titleTemplate: '%s | Serve All You Want',
        htmlAttrs: {
            lang: 'en',
            amp: true
        }
    },
    components: {
        AppBanner,
        AppIntroduction,
        AppFeatures,
        AppPricing,
        AppDemoVideo,
        AppPreview,
        AppTryItForFree,
        AppSampleOrders,
        AppConsultation,
        AppSmallrticle,
    },
    mounted () {
        this.$gtag.event('home', { method: 'Google' })
    },
    methods: {
        async getCategory () {
            const payload = {
                limit: 3,
                offset: 0
            }

            const rest = await axios.post('/api/public/category', payload)

            if (rest && rest.status === 200) {
                const data = rest.data.data
                const payload = data && data.map((dt) => {
                    return {
                        id: dt.id,
                        image: '/contents/categories/thumbnails/' + dt.image,
                        title: dt.name,
                        description: dt.description
                    }
                })
                this.categories = payload
            }
        },
        async getProduct () {
            const payload = {
                limit: 3,
                offset: 0
            }

            const rest = await axios.post('/api/public/product', payload)

            if (rest && rest.status === 200) {
                const data = rest.data.data
                const payload = data && data.map((dt) => {
                    return {
                        id: dt.product.id,
                        product_id: dt.product.product_id,
                        image: dt.images[0] ? '/contents/products/thumbnails/' + dt.images[0].image : '',
                        title: dt.product.name,
                        price: dt.details[0] ? dt.details[0].price : 0,
                        is_available: dt.product.is_available,
                        available: dt.product.is_available ? 'Available' : 'Unavailable',
                        category: dt.product.ctr_name,
                        description: dt.product.description
                    }
                })
                this.products = payload
            }
        },
        async getBenefit () {
            const payload = {
                limit: 3,
                offset: 0
            }

            const rest = await axios.post('/api/public/benefit', payload)

            if (rest && rest.status === 200) {
                const data = rest.data.data
                const payload = data && data.map((dt) => {
                    return {
                        id: dt.id,
                        image: '/contents/benefits/thumbnails/' + dt.image,
                        title: dt.title,
                        description: dt.description
                    }
                })
                this.benefit = payload
            }
        },
        async getArticle () {
            const payload = {
                limit: 3,
                offset: 0
            }

            const rest = await axios.post('/api/public/article', payload)

            if (rest && rest.status === 200) {
                const data = rest.data.data
                const payload = data && data.map((dt) => {
                    return {
                        ...dt,
                        id: dt.id,
                        image: '/contents/articles/thumbnails/' + dt.image,
                        title: dt.title,
                        description: dt.description
                    }
                })
                this.articles = payload
            }
        },
        onRegister () {
            console.log('REGISTER')
        }
    },
    data () {
        return {
            products: [],
            categories: [],
            benefit: [],
            articles: [],
            feedback: []
        }
    }
}
</script>

<style scoped>
.self-padding {
    padding-top: 50px;
    padding-bottom: 50px;
}
</style>
