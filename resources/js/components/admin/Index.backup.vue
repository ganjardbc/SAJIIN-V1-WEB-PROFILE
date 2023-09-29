<template>
    <div id="App" style="padding: 0 0;">
        <div style="padding: 15px; padding-bottom: 0;">
            <h2 class="fonts fonts-16 semibold black">Invitations</h2>
        </div>
        <div v-if="!visibleLoader" class="display-flex display-mobile space-between wrap" style="padding: 0; padding-bottom: 0;">
            <div v-for="(dt, i) in datas" :key="i" class="width width-row-2">
                <div style="margin: 15px;">
                    <div class="card bg-white box-shadow" style="margin: 0 0;">
                        <div style="position: absolute; top: 15px; right: 15px;">
                            <div 
                                :class="'card-capsule ' + (dt.invitation.status === 'active' ? 'active' : '')" 
                                style="text-transform: capitalize; display: inline-block; padding-top: 2px; padding-bottom: 2px;">
                                {{ dt.invitation.status }}
                            </div>
                        </div>
                        <div class="display-flex">
                            <div style="width: 80px; margin-right: 15px;">
                                <div class="image image-padding">
                                    <img :src="dt.invitation ? invitationImageThumbnailUrl + dt.invitation.cover : ''" alt="">
                                </div>
                            </div>
                            <div style="width: calc(100% - 95px;">
                                <h2 class="fonts fonts-12 semibold black">{{ dt.invitation.title }}</h2>
                                <div class="display-flex">
                                    <div class="width width-30">
                                        <div class="fonts fonts-10 grey">Exp Date</div>
                                    </div>
                                    <div class="width width-70">
                                        <VueCountdown :time="dt.invitation.exp_date" v-slot="{ days }">
                                            <div class="fonts fonts-10 black">{{ days }} Days</div>
                                        </VueCountdown>
                                    </div>
                                </div>
                                <div class="display-flex">
                                    <div class="width width-30">
                                        <div class="fonts fonts-10 grey">Theme</div>
                                    </div>
                                    <div class="width width-70">
                                        <div class="fonts fonts-10 black">{{ dt.theme.name }}</div>
                                    </div>
                                </div>
                                <div class="display-flex">
                                    <div class="width width-30">
                                        <div class="fonts fonts-10 grey">Song</div>
                                    </div>
                                    <div class="width width-70">
                                        <div class="fonts fonts-10 black">{{ dt.song.name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="width width-100 display-flex align-right">
                            <router-link :to="{name: 'generate', params: {id: dt.invitation.short_link}, query: {kepada: 'Saji-in'}}">
                                <button class="btn btn-icon btn-white">
                                    <i class="fa fa-lg fa-globe"></i>
                                </button>
                            </router-link>
                            <router-link :to="{name: 'invitations'}">
                                <button class="btn btn-icon btn-white">
                                    <i class="fa fa-lg fa-pencil-alt"></i>
                                </button>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <AppLoader />
        </div>
    </div>
</template>

<script>
import moment from 'moment'
import VueCountdown from '@chenfengyuan/vue-countdown'
import axios from 'axios'
import AppCardDashboard from '../modules/AppCardDashboard'
import AppLoader from '../modules/AppLoader'

export default {
    name: 'App',
    data () {
        return {
            visibleLoader: false,
            datas: [],
            dataUser: null 
        }
    },
    mounted () {
        this.dataUser = this.$cookies.get('user')
        this.getData()
        this.$gtag.event('admin', { method: 'Google' })
    },
    components: {
        AppCardDashboard,
        VueCountdown,
        AppLoader
    },
    methods: {
        async getData () {
            this.visibleLoader = true 

            const token = 'Bearer '.concat(this.$cookies.get('token'))
            let payload = {
                limit: 1000,
                offset: 0
            }

            if (this.dataUser.role_name !== 'admin') {
                payload.user_id = this.dataUser.id
            }
            
            const rest = await axios.post('/api/invitation/getAll', payload, { headers: { Authorization: token } })

            if (rest && rest.status === 200) {
                const data = rest.data.data
                this.datas = data && data.map((dt) => {
                    const crn_date = moment(dt.invitation.created_at).add(1, 'Y')
                    const now = new Date();
                    const time = new Date(crn_date).getTime() 
                    const exp_date = time - now
                    const rest_exp_date = exp_date > 0 ? exp_date : 0
                    return {...dt, invitation: {...dt.invitation, exp_date: rest_exp_date}}
                })
                this.visibleLoader = false 
            } else {
                this.visibleLoader = false 
            }
        }
    }
}
</script>
