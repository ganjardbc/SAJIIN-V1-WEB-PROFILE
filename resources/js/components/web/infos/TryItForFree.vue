<template>
    <div id="TryItForFree" class="bg-main-transparent">
        <div class="main-screen padding padding-top-50px padding-bottom-50px">
            <div class="padding padding-15px">
                <div class="display-flex space-between align-center display-mobile">
                    <div class="width width-40 width-mobile padding padding-top-15px padding-bottom-15px">
                        <VueCountdown :time="selectedTime" v-slot="{ days, hours, minutes, seconds }" class="display-flex align-center space-between">
                            <div class="card bg-main box-shadow" style="padding: 0;">
                                <div class="padding padding-15px">
                                    <div class="fonts fonts-22px white semibold align-center">{{ days }}</div>
                                    <div class="fonts fonts-13px white align-center">Hari</div>
                                </div>
                            </div>
                            <div class="padding padding-10px">
                                <div class="fonts fonts-32px grey">:</div>
                            </div>
                            <div class="card bg-main box-shadow" style="padding: 0;">
                                <div class="padding padding-15px">
                                    <div class="fonts fonts-22px white semibold align-center">{{ hours }}</div>
                                    <div class="fonts fonts-13px white align-center">Jam</div>
                                </div>
                            </div>
                            <div class="padding padding-10px">
                                <div class="fonts fonts-32px grey">:</div>
                            </div>
                            <div class="card bg-main box-shadow" style="padding: 0;">
                                <div class="padding padding-15px">
                                    <div class="fonts fonts-22px white semibold align-center">{{ minutes }}</div>
                                    <div class="fonts fonts-13px white align-center">Menit</div>
                                </div>
                            </div>
                            <div class="padding padding-10px">
                                <div class="fonts fonts-32px grey">:</div>
                            </div>
                            <div class="card bg-main box-shadow" style="padding: 0;">
                                <div class="padding padding-15px">
                                    <div class="fonts fonts-22px white semibold align-center">{{ seconds }}</div>
                                    <div class="fonts fonts-13px white align-center">Detik</div>
                                </div>
                            </div>
                        </VueCountdown>
                    </div>
                    <div class="width width-50 width-mobile">
                        <h1 class="fonts fonts-32px main bold">Gratis 3 Bulan</h1>
                        <p class="fonts fonts-16px grey">
                            Coba dan gunakan Saji-in secara gratis selama 3 bulan dengan semua fitur dari Saji-in Pro.
                        </p>
                        <div class="width width-300px width-mobile padding padding-top-30px">
                            <router-link 
                                :to="{name: 'pricing'}" 
                                class="btn btn-big btn-green" 
                                style="margin-left: 0;">
                                Lihat Penawaran
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueCountdown from '@chenfengyuan/vue-countdown'

export default {
    name: 'TryItForFree',
    components: {
        VueCountdown
    },
    computed: {
        selectedTime() {
            // return new Date('2023-12-31').getTime()
            const now = new Date()
            const time = new Date('2023-12-31')
            const result = time != 'Invalid Date' ? time.getTime() - now.getTime() : null 
            return result > 0 ? result : null

        }
    }
}
</script>