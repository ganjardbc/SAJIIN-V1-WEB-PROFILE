<template>
    <div id="App" class="display-popup">
        <div class="post-middle-absolute card box-shadow bg-white width width-350px">
            <div class="padding padding-30px">
                <div class="display-flex column align-center">
                    <i class="fonts fonts-64 primary far fa-4x fa-question-circle"></i>
                    <div class="fonts fonts-12 semibold black margin margin-top-30px margin-bottom-30px">
                        {{ title }}
                    </div>
                    <div class="display-flex space-between width width-100">
                        <button class="btn btn-grey width width-48" @click="onClickNo">
                            Batalkan
                        </button>
                        <button class="btn btn-main width width-48" @click="onClickYes">
                            Iya, Lanjutkan
                        </button>
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
    },
    methods: {
        onClickNo() {
            this.$emit('onClickNo')
        },
        onClickYes() {
            this.$emit('onClickYes')
        }
    }
}
</script>