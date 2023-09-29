<template>
    <div id="App">
        <div 
            :class="disableSpaceBetween ? 'display-flex' : 'display-flex space-between'" 
            style="cursor: pointer;"
            @click="openVisible">
            <div style="margin-top: 5px;">
                <div class="fonts fonts-13 black semibold">{{ title ? title : 'Show Hide' }}</div>
            </div>
            <div style="margin-left: 5px;">
                <button :class="'btn btn-small-icon ' + (visible ? 'btn-grey' : 'btn-white')">
                    <i :class="'fa fa-lw ' + (visible ? 'fa-chevron-up' : 'fa-chevron-down')"></i>
                </button>
            </div>
        </div>
        <div :class="visible ? 'show-app' : 'hide-app'">
            <slot />
        </div>
    </div>
</template>
<script>
export default {
    name: 'App',
    data () {
        return {
            visible: false
        }
    },
    mounted () {
        this.visible = this.isVisible ? true : false
    },
    props: {
        isVisible: {
            type: Boolean,
            required: false
        },
        disableSpaceBetween: {
            type: Boolean,
            required: false
        },
        title: {
            type: String,
            required: false
        },
    },
    methods: {
        openVisible () {
            this.visible = !this.visible
        }
    }
}
</script>