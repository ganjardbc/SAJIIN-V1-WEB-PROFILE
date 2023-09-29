<template>
    <div id="App" class="display-popup">
        <div class="post-middle-absolute width width-400px width-mobile">
            <div class="padding padding-15px">
                <div class="card box-shadow bg-white">
                    <div class="padding padding-30px">
                        <div class="display-flex column align-center">
                            <i :class="`fonts fonts-64 primary ${icon ? icon : 'far fa-4x fa-check-circle'}`"></i>
                            <div class="fonts fonts-12 semibold black align-center margin margin-top-30px margin-bottom-30px">
                                {{ title }}
                            </div>
                            <button class="btn btn-main btn-full" @click="onClickOk">
                                {{ enableEnglish ? 'Ok, I Understand' : 'Ok, Saya Mengerti' }}
                            </button>
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
    props: {
        title: null,
        icon: null,
        enableEnglish: false,
    },
    methods: {
        onClickOk() {
            this.$emit('onClickOk')
        }
    }
}
</script>