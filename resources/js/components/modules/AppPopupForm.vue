<template>
    <div id="AppPopupForm" class="display-popup">
        <div class="post-center" style="padding-top: 15px; padding-bottom: 15px;">
            <div 
                class="card-popup bg-white box-shadow" 
                :style="enableRadius ? 'border-radius: 10px;' : 'border-radius: 0;'">
                <div class="width width-100 width-center width-mobile">
                    <div class="display-flex justify-content">
                        <div style="width: calc(100% - 90px); margin-top: 8px;">
                            <div class="fonts normal semibold">{{ title }}</div>
                        </div>
                        <div class="display-flex align-right" style="width: 150px;">
                            <button v-if="enableSaveButton" class="btn btn-icon btn-white" @click="onSave">
                                <i class="fa fa-lw fa-save" />
                            </button>
                            <button class="btn btn-icon btn-white" @click="onClose">
                                <i class="fa fa-lg fa-times" />
                            </button>
                        </div>
                    </div>
                    <div style="max-height: calc(100vh - 150px); overflow-y: auto; padding-top: 15px; padding-right: 2px;">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AppPopupForm',
    props: {
        title: {
            type: String,
            required: true
        },
        enableRadius: {
            type: Boolean,
            required: false
        },
        enableSaveButton: {
            type: Boolean,
            required: false
        },
        onSave: {
            type: Function,
            required: false
        },
        onClose: {
            type: Function,
            required: false
        }
    }
}
</script>