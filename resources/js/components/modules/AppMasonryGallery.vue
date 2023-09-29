<template>
    <div id="App">
        <div class="theme-masonry-gallery">
            <div class="card-masonry" v-for="(dt, i) in data" :key="i">
                <img class="img box-shadow" :src="(dt.image ? (galleryImageCoverUrl + dt.image) : '')" alt="">
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
}
</script>