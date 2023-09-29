<template>
    <div id="App">
        <youtube 
            :video-id="videoId"
            :player-width="width ? width : '100%'"
            :player-height="height ? height : '300'"></youtube>
    </div>
</template>
<script>
import { getIdFromURL } from 'vue-youtube-embed'

export default {
    name: 'App',
    props: {
        data: null,
        width: null,
        height: null,
    },
    computed: {
        videoId() {
            let video = ''
            if (this.data) {
                video = getIdFromURL(this.data)
            }
            return video
        }
    }
}
</script>