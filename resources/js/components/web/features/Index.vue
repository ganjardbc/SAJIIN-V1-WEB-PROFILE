<template>
    <div id="App">
        <AppFeatures />
    </div>
</template>
<script>
import AppFeatures from '../infos/Features'

export default {
    name: 'App',
    metaInfo: {
        title: 'Saji-in',
        titleTemplate: '%s | Fitur Undangan',
        htmlAttrs: {
            lang: 'en',
            amp: true
        }
    },
    components: {
        AppFeatures
    }
}
</script>