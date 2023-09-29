<template>
    <div 
        id="App" 
        :class="`form-side-popup ${visibleForm ? 'show' : 'hide'}`">
        <div class="fsp-header display-flex space-between align-center">
            <div class="fonts normal semibold">{{ title ? title : 'Form' }}</div>
            <div class="display-flex align-right">
                <button 
                    class="btn btn-icon btn-white" 
                    title="Close"
                    @click="onClose">
                    <i class="fa fa-lg fa-times" />
                </button>
            </div>
        </div>
        <div :class="`${enableSaveButton ? 'fsp-content-with-footer' : 'fsp-content'}`">
            <slot />
        </div>
        <div 
            v-if="enableSaveButton"
            class="fsp-footer display-flex space-between align-center">
            <button 
                class="btn btn-main btn-full" 
                @click="onSave">
                Simpan Data 
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'App',
    data () {
        return {}
    },
    props: {
        title: {
            type: String,
            required: true
        },
        visibleForm: {
            type: Boolean,
            default: false,
            required: true
        },
        enableCreateButton: {
            type: Boolean,
            default: false,
            required: false
        },
        enableSaveButton: {
            type: Boolean,
            default: false,
            required: false
        }
    },
    methods: {
        onCreate () {
            this.$emit('onCreate')
        },
        onClose () {
            this.$emit('onClose')
        },
        onSave () {
            this.$emit('onSave')
        }
    }
}
</script>