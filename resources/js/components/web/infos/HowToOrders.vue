<template>
    <div id="App">
        <div class="main-screen" style="padding-top: 0;">
            <div class="main-screen" style="margin-top: 0;">
                <div class="self-padding" style="padding-bottom: 0;">
                    <div class="space">
                        <h2 class="fonts fonts-32px align-center bold black no-line-height theme-how-to-order-animate" style="margin-bottom: 15px;">
                            Cara Mendaftarkan Toko ?
                        </h2>
                        <p class="fonts fonts-16px align-center grey theme-how-to-order-animate">
                            Daftarkan toko kamu dan dapatkan semua fitur dari Saji-in secara gratis. <br /> 
                            Atau bisa juga langsung hubungi kita via WhatsApp di sini <br /> 
                            <a href="https://wa.me/6289699181669?text=Hallo admin saya mau daftarkan toko di saji-in" target="_blank">+62-8969-9181-669</a>
                        </p>
                    </div>
                </div>

                <div class="width width-60 width-mobile width-center" style="margin-bottom: 40px;">
                    <div class="card no-margin no-hover no-radius box-shadow theme-how-to-order-animate" style="padding-top: 40px; padding-bottom: 20px;">
                        <div class="content-center">
                            <div class="fonts fonts-12 semibold black no-line-height theme-how-to-order-animate" style="margin-bottom: 15px;">Cara Mendaftarkan Toko</div>
                            <div class="display-flex center">
                                <div class="card-value theme-how-to-order-animate">
                                    <i class="fa fa-lw fa-star" />
                                    Direkomendasikan
                                </div>
                            </div>
                        </div>
                        <div v-for="(dt, i) in data1" :key="i" class="card-step" style="margin-top: 15px; margin-bottom: 15px;">
                            <div class="number theme-how-to-order-animate">
                                <div class="val">{{ dt.number }}</div>
                            </div>
                            <div class="info">
                                <div style="padding: 5px 15px;">
                                    <div class="fonts fonts-11 black semibold theme-how-to-order-animate" style="margin-bottom: 5px;">{{ dt.title }}</div>
                                    <div class="fonts fonts-11 grey theme-how-to-order-animate"><span v-html="dt.description"></span></div>
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
export default {
    name: 'App',
    metaInfo: {
        title: 'Saji-in',
        titleTemplate: '%s | Buat Undangan',
        htmlAttrs: {
            lang: 'en',
            amp: true
        }
    },
    data () {
        return {
            data1: [
                {number: '1', title: 'Chat kita via WhatsApp', description: 'Kamu bisa menghubungi kita via chat di WhatsApp di kontak yang tersedia atau di nomor ini <a href="https://wa.me/6289699181669?text=Hallo admin saya mau daftarkan toko di saji-in" target="_blank">+62-8969-9181-669</a>'},
                {number: '2', title: 'Kirim data Toko', description: 'Kirim data toko seperti nama toko, pemilik, lokasi, no hp/telpon, logo dan lain sebagainya.'},
                {number: '3', title: 'Lakukan pembayaran', description: 'Kamu bisa menggunakan saji-in gratis selama 3 bulan, atau langsung bisa menggunakan saji-in pro agar bisa mendaftarkan hingga 3 toko.'},
                {number: '4', title: 'Tunggu kita siapkan saji-in', description: 'Proses pendaftaran Toko paling lama 1 sampai 2 hari atau 2x24jam setelah ada pembayaran jika ini saji-in pro.'},
                {number: '5', title: 'Toko bisa melakukan order', description: 'Selesai, kita bakal kirim credential untuk login dan kamu tinggal gunakan saji-in dan buat pesanan sebanyak yang kamu mau.'}
            ],
        }
    },
    mounted () {},
    methods: {}
}
</script>