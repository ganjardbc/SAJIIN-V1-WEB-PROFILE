<template>
    <div id="SampleOrders">
        <div class="main-screen" style="margin: 30px auto;">
            <div class="padding padding-15px">
                <div class="bg-white border-radius box-shadow theme-sample-orders-animate">
                    <div style="padding: 30px;">
                        <h1 class="fonts fonts-16px main semibold theme-sample-orders-animate">
                            Saji-in
                        </h1>
                        <h2 
                            class="fonts fonts-18px black bold theme-sample-orders-animate" 
                            style="margin-bottom: 30px;">
                            Serve All You Want
                        </h2>
                        <div class="display-flex space-between align-center display-mobile">
                            <div class="width width-60 width-mobile padding padding-mobile-bottom-30px">
                                <div style="padding: 30px; border-left: 4px #13aff0 solid;">
                                    <div class="fonts fonts-16px grey theme-sample-orders-animate">
                                        <i>“We always build the trust value from the customers by paying attention to the quality of our services, products, processes to maximum work results.”</i>
                                    </div>
                                </div>
                            </div>
                            <div class="width width-30 width-mobile display-flex flex-end padding padding-mobile-top-30px">
                                <router-link :to="{name: 'how-to-orders'}" class="btn btn-big btn-main btn-full">
                                    Coba Gratis
                                </router-link>
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
    name: 'SampleOrders',
    mounted () {},
    methods: {}
}
</script>