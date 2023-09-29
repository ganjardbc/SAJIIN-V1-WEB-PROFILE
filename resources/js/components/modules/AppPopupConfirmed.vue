<template>
    <div id="App" class="display-popup">
        <div class="post-middle-absolute width width-400px width-mobile">
            <div class="padding padding-15px">
                <div class="card box-shadow bg-white">
                    <div class="padding padding-30px">
                        <div class="display-flex column align-center">
                            <i class="fonts fonts-64 primary far fa-4x fa-question-circle"></i>
                            <div class="fonts fonts-12 semibold black align-center margin margin-top-30px margin-bottom-30px">
                                {{ title }}
                            </div>
                            <div class="display-flex space-between width width-100">
                                <button class="btn btn-grey width width-48" @click="onClickNo">
                                    {{ enableEnglish ? 'Cancel' : 'Batalkan' }}
                                </button>
                                <button class="btn btn-main width width-48" @click="onClickYes">
                                    {{ enableEnglish ? 'Yes, Continue' : 'Iya, Lanjutkan' }}
                                </button>
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
    props: {
        title: null,
        enableEnglish: false,
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