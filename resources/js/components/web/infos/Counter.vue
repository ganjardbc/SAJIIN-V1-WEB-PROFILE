<template>
    <div id="App" class="main-screen" style="margin-top: 0;">
        <div class="display-flex center wrap">
            <div v-for="(dt, i) in counters" :key="i" class="width width-row-3 width-mobile">
                <div class="padding padding-15px">
                    <div class="card bg-white box-shadow display-flex theme-feature-animate">
                        <div style="width: calc(100% - 65px);">
                            <div class="fonts fonts-16px align-left black semibold theme-feature-animate" style="margin-bottom: 5px;">{{ dt.title }}</div>
                            <div class="fonts fonts-42px align-left main semibold theme-feature-animate" style="line-height: 1;">{{ dt.value }}</div>
                        </div>
                        <div style="width: 50px; margin-left: 15px;">
                            <div class="image image-padding image-circle bg-white box-shadow theme-feature-animate">
                                <i :class="`post-middle-absolute fonts fonts-16 primary ${dt.icon}`"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    name: 'App',
    data() {
        return {
            counters: [
                {id: 'bride', icon: 'fa fa-lg fa-user-friends', isNew: false, value: 0, title: 'Pasangan', description: 'Jumlah pasangan.'},
                {id: 'invitation', icon: 'fa fa-lg fa-envelope', isNew: false, value: 0, title: 'Undangan', description: 'Jumlah undangan.'},
                {id: 'guest', icon: 'fa fa-lg fa-users', isNew: false, value: 0, title: 'Tamu', description: 'Jumlah tamu.'},
            ]
        }
    },
    mounted () {
        this.getCounter()
    },
    methods: {
        async getCounter () {
            const rest = await axios.post('/api/public/counter')
            if (rest && rest.status === 200) {
                const data = rest.data.data
                this.counters[0].value = data.brides
                this.counters[1].value = data.invitations
                this.counters[2].value = data.guests
            }
        },
    }
}
</script>