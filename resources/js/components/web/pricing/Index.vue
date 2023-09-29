<template>
    <div id="App" class="padding padding-bottom-25px">
        <AppPricing />
    </div>
</template>
<script>
import AppPricing from '../infos/Pricing'

export default {
    name: 'App',
    metaInfo: {
        title: 'Saji-in',
        titleTemplate: '%s | Harga Undangan',
        htmlAttrs: {
            lang: 'en',
            amp: true
        }
    },
    components: {
        AppPricing
    }
}
</script>