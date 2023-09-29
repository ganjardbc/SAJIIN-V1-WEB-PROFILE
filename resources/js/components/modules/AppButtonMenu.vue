<template>
    <div id="AppButtonMenu" style="position: relative;">
        <button :class="button ? button : 'btn btn-sekunder btn-icon btn-radius'" :style="visiblePopup && 'background-color: #f0f0f0;'" @click="onShow">
            <i :class="icon ? icon : 'fa fa-lg fa-ellipsis-h'"></i>
        </button>
        <div v-if="visiblePopup" class="card border-full box-shadow" style="position: absolute; top: 45px; right: 0; width: 150px; z-index: 10; padding: 0 0; border-radius: 5px; background-color: #fff;">
            <ul class="menu-list mobile hover with-icon">
                <li v-for="(dt, index) in data" :key="index" class="ml-list">
                    <div class="ml-link" :style="dt.icon ? 'cursor: pointer; padding: 5px 0;' : 'cursor: pointer; padding: 10px;'" @click="onHide(index)">
                        <div v-if="dt.icon" class="ml-icon">
                            <i :class="dt.icon" />
                        </div>
                        <div class="ml-label" style="width: 100%;">
                            <div class="post-top">{{ dt.label }}</div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    name: 'AppButton',
    data () {
        return {
            visiblePopup: false
        }
    },
    props: {
        button: {
            type: String,
            required: false
        },
        icon: {
            type: String,
            required: false
        },
        data: {
            required: true
        },
        onChange: {
            type: Function,
            required: false
        }
    },
    methods: {
        onHide (index) {
            this.visiblePopup = false
            this.onChange(index)
        },
        onShow () {
            this.visiblePopup = !this.visiblePopup
        }
    }
}
</script>