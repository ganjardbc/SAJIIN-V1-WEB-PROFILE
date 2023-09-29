<template>
    <div id="App" style="padding-top: 0;">
        <div class="main-screen" style="margin-top: 0;">
            <div class="space">
                <h2 class="fonts fonts-32px align-center bold black no-line-height" style="margin-bottom: 15px;">
                    Blog & Artikel
                </h2>
                <p class="fonts fonts-16px align-center grey">
                    Ikuti info dan berita terbaru seputar Saji-in.
                </p>
            </div>

            <Card :data="articles" />

            <AppLoader v-if="visibleLoader" style="margin-top: 40px;" />

            <div class="display-flex center" style="margin-top: 40px;">
                <button 
                    class="btn btn-big btn-main-reverse with-border"
                    @click="toArticle">
                    Semua Blog & Article
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { gsap, ScrollTrigger } from 'gsap/all'
import axios from 'axios'
import icon from '../../../../img/contents/1.jpg'
import AppLoader from '../../modules/AppLoader'
import Card from './Card'

export default {
    components: {
        AppLoader,
        Card,
    },
    mounted () {
        this.getArticle(this.limit, this.offset)
        const val = this 
        gsap.registerPlugin(ScrollTrigger)
        gsap.utils.toArray(".theme-article-animate").forEach(function(elm) {
            val.hide(elm)
            ScrollTrigger.create({
                trigger: elm,
                onEnter: function() { val.animateFrom(elm) }, 
                onEnterBack: function() { val.animateFrom(elm, -1) },
                onLeave: function() { val.hide(elm) }
            })
        })
    },
    methods: {
        toArticle () {
            this.$router.push({name: 'articles'})
        },
        animateFrom (elem, direction) {
            direction = direction || 1
            var x = 0,
                y = direction * 100
            if (elem.classList.contains("theme-article-animate-fromLeft")) {
                x = -100
                y = 0
            } 
            if (elem.classList.contains("theme-article-animate-fromRight")) {
                x = 100
                y = 0
            }
            elem.style.transform = "translate(" + x + "px, " + y + "px)"
            elem.style.opacity = "0"
            gsap.fromTo(elem, {x: x, y: y, autoAlpha: 0}, {
                duration: 1.25, 
                x: 0,
                y: 0, 
                autoAlpha: 1, 
                ease: "expo", 
                overwrite: "auto"
            })
        },
        hide(elem) {
            gsap.set(elem, {autoAlpha: 0})
        },
        async getArticle (limit, offset) {
            this.visibleLoader = true 

            let article = []

            if (offset > 0) {
                article = Object.assign([], this.articles)
            } else {
                article = []
            }

            const payload = {
                limit: limit,
                offset: offset
            }

            const rest = await axios.post('/api/public/article', payload)

            if (rest && rest.status === 200) {
                const data = rest.data.data
                data && data.map((dt) => {
                    return article.push({
                        ...dt,
                        id: dt.id,
                        image: '/contents/articles/thumbnails/' + dt.image,
                        title: dt.title,
                        description: dt.description
                    })
                })
                this.articles = article
                this.visibleLoader = false 

                if (data.length > 0) {
                    this.offset += this.limit
                }

                if (data.length < this.limit) {
                    this.visibleLoadMore = false
                } else {
                    this.visibleLoadMore = true
                }
            } else {
                this.visibleLoader = false 
            }
        },
        onMore () {
            this.getArticle(this.limit, this.offset)
        }
    },
    data () {
        return {
            visibleLoader: false,
            icon: icon,
            limit: 3,
            offset: 0,
            visibleLoadMore: false,
            articles: []
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
