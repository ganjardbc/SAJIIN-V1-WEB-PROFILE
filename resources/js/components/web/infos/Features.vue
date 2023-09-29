<template>
    <div id="SampleQuestion" class="main-screen">
        <div class="self-padding" style="padding-bottom: 0;">
            <div class="space space-center">
                <h2 class="fonts fonts-32px align-center bold black no-line-height theme-home-animate" style="margin-bottom: 15px;">
                    Fitur Lengkap dan Ter-Integrasi
                </h2>
            </div>
        </div>
        <div class="display-flex wrap">
            <div v-for="(dt, i) in categories" :key="i" class="width width-row-3">
                <div style="margin: 15px;">
                    <div class="card-feature no-padding bg-white border-full border-radius theme-feature-animate">
                        <div class="display-flex align-start">
                            <div style="width: 75px; margin-right: 15px;">
                                <div class="image image-padding bg-white theme-feature-animate">
                                    <i :class="`post-middle-absolute fonts fonts-24 primary ${dt.icon}`"></i>
                                </div>
                            </div>
                            <div style="width: calc(100% - 90px);">
                                <div class="fonts fonts-16px black semibold theme-feature-animate" style="margin-bottom: 5px;">{{ dt.title }}</div>
                                <div class="fonts fonts-14px grey theme-feature-animate">{{ dt.description }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="width width-80 width-mobile width-center">
            <div 
                v-for="(dt, i) in data" 
                :key="i" 
                :class="`display-flex display-mobile space-between ${i % 2 !== 0 ? 'row-reverse' : ''}`">
                <div :class="`width width-60 width-mobile`">
                    <div 
                        :class="`display-flex display-mobile ${i % 2 !== 0 ? 'flex-end' : ''}`" 
                        style="width: calc(100% - 30px); padding-left: 15px; padding-right: 15px;">
                        <div class="width width-90 width-mobile theme-home-animate">
                            <div class="image image-padding" style="background-color: #fff;">
                                <img class="img" :src="dt.cover" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width width-40 width-mobile">
                    <div class="post-top post-mobile-none" style="width: calc(100% - 30px); padding-left: 15px; padding-right: 15px;">
                        <div style="margin-bottom: 40px;">
                            <h2 class="fonts fonts-32px bold black no-line-height theme-home-animate" style="margin-bottom: 15px;">{{ dt.title }}</h2>
                            <div class="width width-100 width-mobile">
                                <p class="fonts fonts-16px grey theme-home-animate">{{ dt.subtitle }}</p>
                            </div>
                            <div v-if="dt.contents" style="padding: 15px 0;">
                                <div 
                                    v-for="(ct, j) in dt.contents" 
                                    :key="j" 
                                    class="display-flex align-center" style="padding: 5px 0;">
                                    <div style="width: 50px;">
                                        <i class="fonts fonts-28px main align-center far fa-lg fa-check-circle"></i>
                                    </div>
                                    <div style="width: calc(100% - 50px);">
                                        <div class="fonts fonts-16px grey">{{ ct }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import cover from '../../../../img/banner-1.png'
import countdown from '../../../../img/countdown.png'
import quotes from '../../../../img/quotes.png'

export default {
    name: 'SampleQuestion',
    data() {
        return {
            categories: [
                {cover: countdown, isNew: false, icon: 'fa fa-lg fa-chart-line', title: 'Cashflow Tracking', description: 'Pantau uang yang masuk dan keluar.'},
                {cover: quotes, isNew: false, icon: 'fa fa-lg fa-list', title: 'Order Management', description: 'Kelola pesanan dari kasir sampai ke dapur.'},
                {cover: quotes, isNew: false, icon: 'fa fa-lg fa-glass-cheers', title: 'Digital Menu', description: 'Daftar menu langsung untuk pelanggan.'},
            ],
            data: [
                {
                    cover: cover, 
                    title: 'Cash Flow Tracking', 
                    subtitle: 'Pantau cash yang masuk dan keluar secara realtime sesuai jadwal harian Pembukaan Toko.',
                    contents: [
                        'Pantau cash-in dan cash-out',
                        'Laporan harian dengan cash book',
                        'Atur closing toko dengan cash book'
                    ]
                },
                {
                    cover: cover, 
                    title: 'Order Management', 
                    subtitle: 'Kelola pesanan dengan mudah dari kasir sampai ke dapur.',
                    contents: [
                        'Pantau status pesanan yang berjalan',
                        'Filter pesanan berdasarkan cash book',
                        'Print receipt untuk setiap pesanan',
                        'Semua pesanan langsung ke dapur'
                    ]
                },
                {
                    cover: cover, 
                    title: 'Digital Menu', 
                    subtitle: 'Daftar menu langsung untuk pelanggan hanya dengan scan QR-Code.',
                    contents: [
                        'Scan Menu dengan QR Code',
                        'Pelanggan bisa langsung buat pesanan',
                        'Download receipt untuk pelanggan'
                    ]
                },
                {
                    cover: cover, 
                    title: 'Catalog Product', 
                    subtitle: 'Atur semua product sebanyak yang kamu mau.',
                    contents: [
                        'Tambah product sebanyak-banyaknya',
                        'Atur varian dari setiap product',
                        'Atur discount untuk promosi'
                    ]
                },
                {
                    cover: cover, 
                    title: 'Multi Staff', 
                    subtitle: 'Atur jadwal kerja dan semua staff dalam berbagai role.',
                    contents: [
                        'Jadwal kerja untuk semua staff',
                        'Tiap staff punya akun sendiri',
                        'Beragam role SPV, cashier, kitchen, owner'
                    ]
                },
            ]
        }
    },
}
</script>