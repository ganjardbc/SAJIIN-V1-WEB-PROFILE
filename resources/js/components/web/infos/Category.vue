<template>
    <div id="Category" class="main-screen">
        <div class="self-padding" style="padding-bottom: 0;">
            <div class="space space-center">
                <h2 class="fonts fonts-32px align-center bold black no-line-height theme-home-animate">
                    Kelola dan Pantau Seluruh Pesanan
                </h2>
            </div>
        </div>
        <div class="display-flex center wrap">
            <div v-for="(dt, i) in fiturs" :key="i" class="width width-row-3 width-mobile">
                <div class="padding padding-15px">
                    <div class="card-category">
                        <div class="cover">
                            <div class="image image-padding image-circle bg-white box-shadow theme-home-animate">
                                <i :class="`post-middle-absolute fonts fonts-24 primary ${dt.icon}`"></i>
                            </div>
                        </div>
                        <div class="detail">
                            <div class="fonts fonts-16px black semibold theme-home-animate" style="margin-bottom: 5px;">{{ dt.title }}</div>
                            <div class="fonts fonts-14px grey normal theme-home-animate">{{ dt.description }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import countdown from '../../../../img/countdown.png'
import quotes from '../../../../img/quotes.png'

export default {
    name: 'Category',
    data() {
        return {
            fiturs: [
                {cover: countdown, isNew: false, icon: 'fa fa-lg fa-chart-line', title: 'Cashflow Tracking', description: 'Pantau uang yang masuk dan keluar.'},
                {cover: quotes, isNew: false, icon: 'fa fa-lg fa-list', title: 'Order Management', description: 'Kelola pesanan dari kasir sampai ke dapur.'},
                {cover: quotes, isNew: false, icon: 'fa fa-lg fa-glass-cheers', title: 'Digital Menu', description: 'Daftar menu langsung untuk pelanggan.'},
            ]
        }
    },
}
</script>