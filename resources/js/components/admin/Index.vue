<template>
    <div id="App" style="height: 100%;">
        <div class="padding padding-15px post-middle">
            <AppEmpty 
                icon="fa fa-3x fa-shapes"
                title="WELCOME TO UNDANGABI ADMIN PANEL" />
        </div>
    </div>
</template>

<script>
import AppEmpty from '../modules/AppEmpty'

export default {
    name: 'App',
    data () {
        return {}
    },
    mounted () {},
    components: {
        AppEmpty
    },
    methods: {}
}
</script>
