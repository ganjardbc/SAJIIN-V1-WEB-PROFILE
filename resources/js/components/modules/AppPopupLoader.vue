<template>
    <div id="App" class="display-popup">
        <div class="post-middle-absolute width width-400px width-mobile">
            <div class="padding padding-15px">
                <div class="card box-shadow bg-white">
                    <div class="padding padding-30px">
                        <div class="display-flex column align-center">
                            <i class="fonts fonts-64 primary fa fa-4x fa-spin fa-spinner"></i>
                            <div class="fonts fonts-12 semibold black margin margin-top-30px">
                                {{ title ? title : 'Mohon Tunggu' }}
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
    },
}
</script>