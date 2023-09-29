<template>
    <div id="App" class="display-flex">
        <div class="card-free-trial">
            {{ title ? title : 'FREE TRIAL' }}
        </div>
    </div>
</template>
<script>
export default {
    name: 'App',
    props: {
        title: null 
    }
}
</script>