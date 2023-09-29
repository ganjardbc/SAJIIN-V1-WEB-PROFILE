<template>
    <div id="App" style="padding-bottom: 10px; padding-top: 10px;">
        <div :class="theme">
            <img :src="border" alt="">
        </div>
    </div>
</template>
<script>

export default {
    name: 'App',
    data () {
        return {
            theme: 'theme-greeting top-center',
            border: '/images/cover-top.png'
        }
    }
}
</script>