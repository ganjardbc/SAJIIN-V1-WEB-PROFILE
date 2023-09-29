<template>
    <div id="App">
        <div class="main-screen">
            <div class="self-padding" style="padding-bottom: 0;">
                <div class="space">
                    <h2 class="fonts fonts-32px align-center bold black no-line-height theme-pricing-animate" style="margin-bottom: 15px;">
                        Dapatkan Harga Terbaik di Saji-in POS
                    </h2>
                    <p class="fonts fonts-16px align-center grey theme-pricing-animate">
                        Harga yang kami berikan bersahabat dan terjangkau di semua kalangan.
                    </p>
                </div>
            </div>

            <div class="display-flex display-mobile wrap">
                <div v-for="(dt, i) in pricing" :key="i" class="width width-row-3">
                    <div style="padding: 15px;">
                        <div :class="`card box-shadow background-white theme-pricing-animate-2`" style="overflow: unset;">
                            <div style="padding: 15px;">
                                <div 
                                    v-if="dt.isRecomended" 
                                    class="display-flex center" 
                                    style="position: absolute; top: -10px; right: 0; width: 100%;">
                                    <div class="card-value">
                                        <i class="fa fa-lw fa-star" />
                                        Direkomendasikan
                                    </div>
                                </div>
                                <div class="fonts fonts-18 black semibold align-center theme-pricing-animate-2">{{ dt.title }}</div>
                                <div style="margin-top: 15px; margin-bottom: 50px;">
                                    <div v-if="dt.secondPrice" class="fonts fonts-14 grey align-center theme-pricing-animate-2" style="text-decoration: line-through;">{{ dt.secondPrice }}</div>
                                    <div class="fonts fonts-18 green semibold align-center theme-pricing-animate-2">{{ dt.price }}</div>
                                </div>
                                <button class="btn btn-big btn-main btn-full theme-pricing-animate">
                                    <i class="icn icn-left fa fa-lw fa-shopping-cart" /> Langganan
                                </button>
                                <div class="fonts fonts-13px black align-center" style="padding: 15px 0;">atau</div>
                                <button class="btn btn-big btn-main-reverse btn-full with-border theme-pricing-animate">
                                    Coba Gratis
                                </button>
                                <div v-if="dt.note" class="fonts fonts-10 red align-center theme-pricing-animate-2" style="margin-top: 30px;">{{ dt.note }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="padding padding-15px">
                <div class="card bg-main-transparent">
                    <AppCardCollapse title="Daftar Fitur">
                        <div class="display-flex wrap" style="padding-top: 15px;">
                            <div v-for="(dt, i) in features" :key="i" class="width width-row-2">
                                <div 
                                    class="display-flex align-center theme-pricing-animate" 
                                    style="padding-top: 10px; padding-bottom: 10px;">
                                    <div style="width: 50px; margin-right: 15px;">
                                        <div class="image image-50px image-circle box-shadow bg-white">
                                            <i v-if="dt.status" class="post-middle fonts green far fa-lg fa-check-circle" />
                                            <i v-else class="post-middle fonts red far fa-lg fa-times-circle" />
                                        </div>
                                    </div>
                                    <div class="display-flex" style="width: calc(100% - 65px)">
                                        <div class="fonts fonts-11 black">{{ dt.title }}</div>
                                        <div v-if="dt.note" class="fonts fonts-11 black semibold" style="margin-left: 5px;">{{ dt.note }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </AppCardCollapse>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import coverFree from '../../../../img/free.png'
import coverPro from '../../../../img/pro.png'
import AppCardCollapse from '../../modules/AppCardCollapse'
import AppSampleOrders from './SampleOrders'

const listOfFeatures = [
    {title: 'Unlimited Transaction', status: true},
    {title: 'Product Management', status: true},
    {title: 'Staff/Employee Management', status: true},
    {title: 'Order Management', status: true},
    {title: 'Kitchen Task Lists', status: true},
    {title: 'Digital Menu & Orders', status: true},
    {title: 'Cash Book', status: true},
    {title: 'Cashier App', status: true},
    {title: 'Print Receipt', status: true},
    {title: 'Laporan Penjualan', status: true},
]

export default {
    name: 'App',
    components: {
        AppCardCollapse,
        AppSampleOrders
    },
    props: {
        enableAnimation: {
            default: false
        }
    },
    data () {
        return {
            features: listOfFeatures,
            pricing: [
                {
                    cover: coverPro,
                    icon: 'fa fa-lg fa-circle', 
                    price: 'Rp 39.000', 
                    secondPrice: 'Rp 99.000', 
                    title: '1 Bulan', 
                    isRecomended: true, 
                    type: 'pro', 
                    note: '* Harga untuk 1 Toko',
                    data: listOfFeatures
                },
                {
                    cover: coverFree,
                    icon: 'fa fa-lg fa-circle', 
                    price: 'Rp 199.000', 
                    secondPrice: 'Rp 594.000', 
                    title: '6 Bulan', 
                    isRecomended: false, 
                    type: 'regular', 
                    note: '* Harga untuk 1 Toko',
                    data: listOfFeatures
                },
                {
                    cover: coverFree,
                    icon: 'fa fa-lg fa-circle', 
                    price: 'Rp 399.000', 
                    secondPrice: 'Rp 1.188.000', 
                    title: '12 Bulan', 
                    isRecomended: false, 
                    type: 'regular', 
                    note: '* Harga untuk 1 Toko',
                    data: listOfFeatures
                },
            ]
        }
    },
    mounted () {},
    methods: {}
}
</script>