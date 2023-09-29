<template>
    <div id="form">
        <AppSideForm 
            :title="title" 
            :enableSaveButton="this.title !== 'VIEW' ? true : false"
            :onSave="onButtonSave"
            :onClose="onClose">
            <div v-if="this.title !== 'CREATE' ? true : false" class="field-group margin margin-bottom-15-px">
                <div class="field-label">IMAGE</div>
                <AppImage 
                    :image.sync="image"
                    :isEnable="this.title !== 'VIEW' ? true : false"
                    :onUpload="(data) => uploadImage(data)"
                    :onRemove="removeImage"
                />
                <div v-if="formMessage" class="fonts micro bold" style="color: red; margin-top: 5px;">
                    {{ formMessage && formMessage.image && formMessage.image[0] }}
                </div>
            </div>
            <div class="field-group margin margin-bottom-15-px">
                <div class="field-label">ID</div>
                <input 
                    type="text" 
                    placeholder="" 
                    class="field field-sekunder" 
                    name="id" 
                    id="id" 
                    v-model="formData.id"
                    readonly>
            </div>
            <div class="field-group margin margin-bottom-15-px">
                <div class="field-label">FEEDBACK ID</div>
                <input 
                    type="text" 
                    placeholder="" 
                    class="field field-sekunder" 
                    name="feedback_id" 
                    id="feedback_id" 
                    v-model="formData.feedback_id"
                    readonly>
                <div v-if="formMessage" class="fonts micro bold" style="color: red; margin-top: 5px;">
                    {{ formMessage && formMessage.feedback_id && formMessage.feedback_id[0] }}
                </div>
            </div>
            <div class="field-group margin margin-bottom-15-px">
                <div class="field-label">NAME</div>
                <input 
                    type="text" 
                    placeholder="" 
                    class="field field-sekunder" 
                    name="name" 
                    id="name" 
                    v-model="formData.name"
                    :readonly="this.title === 'VIEW' ? true : false">
                <div v-if="formMessage" class="fonts micro bold" style="color: red; margin-top: 5px;">
                    {{ formMessage && formMessage.name && formMessage.name[0] }}
                </div>
            </div>
            <div class="field-group margin margin-bottom-15-px">
                <div class="field-label">WORK</div>
                <input 
                    type="text" 
                    placeholder="" 
                    class="field field-sekunder" 
                    name="work" 
                    id="work" 
                    v-model="formData.work"
                    :readonly="this.title === 'VIEW' ? true : false">
                <div v-if="formMessage" class="fonts micro bold" style="color: red; margin-top: 5px;">
                    {{ formMessage && formMessage.work && formMessage.work[0] }}
                </div>
            </div>
            <div class="field-group margin margin-bottom-15-px">
                <div class="field-label">STATUS</div>
                <div class="display-flex">
                    <label class="radio">
                        <input 
                            type="radio" 
                            name="status"
                            id="active"
                            value="active"
                            v-model="formData.status"
                            :readonly="this.title === 'VIEW' ? true : false" />
                        <span class="checkmark" />
                        <span class="fonts micro">
                            Active
                        </span>
                    </label>

                    <label class="radio">
                        <input 
                            type="radio" 
                            name="status"
                            id="inactive"
                            value="inactive"
                            v-model="formData.status"
                            :readonly="this.title === 'VIEW' ? true : false" />
                        <span class="checkmark" />
                        <span class="fonts micro">
                            Inactive
                        </span>
                    </label>
                </div>
                <div v-if="formMessage" class="fonts micro bold" style="color: red; margin-top: 5px;">
                    {{ formMessage && formMessage.status && formMessage.status[0] }}
                </div>
            </div>
            <div class="field-group margin margin-bottom-15-px">
                <div class="field-label">FEEDBACK</div>
                <textarea 
                    name="feedback" 
                    id="feedback" 
                    class="field field-sekunder field-textarea" 
                    v-model="formData.feedback"
                    :readonly="this.title === 'VIEW' ? true : false"></textarea>
                <div v-if="formMessage" class="fonts micro bold" style="color: red; margin-top: 5px;">
                    {{ formMessage && formMessage.feedback && formMessage.feedback[0] }}
                </div>
            </div>
        </AppSideForm>
    </div>
</template>

<script>
import AppSideForm from '../../modules/AppSideForm'
import AppImage from '../../modules/AppImage'

const payload = {
    id: '',
    feedback_id: '',
    image: '',
    name: '',
    work: '',
    feedback: '',
    status: '',
    is_available: 0,
}

export default {
    name: 'form',
    data () {
        return {
            isView: false,
            image: '',
            formData: {...payload},
            formMessage: []
        }
    },
    mounted () {
        this.formData = {...payload}
    },
    components: {
        AppSideForm: AppSideForm,
        AppImage: AppImage
    },
    props: {
        data: {
            required: true
        },
        message: {
            required: false
        },
        title: {
            type: String,
            required: true
        },
        uploadImage: {
            type: Function,
            required: false,
        },
        removeImage: {
            type: Function,
            required: false,
        },
        onSave: {
            type: Function,
            required: true
        },
        onClose: {
            type: Function,
            required: true
        }
    },
    methods: {
        onButtonSave () {
            const time = new Date().getTime()
            const newPayload = this.title === 'CREATE' ? {
                ...this.formData,
                feedback_id: "FE-" + time,
            } : {...this.formData}
            this.onSave(newPayload)
        }
    },
    watch: {
        data: function (props, prevProps) {
            if (props) {
                this.formData = {
                    ...this.formData,
                    id: props.id,
                    feedback_id: props.feedback_id,
                    image: props.image,
                    name: props.name,
                    work: props.work,
                    feedback: props.feedback,
                    status: props.status,
                    is_available: props.is_available
                }
                this.image = props.image ? this.feedbackImageThumbnailUrl + props.image : ''
            } else {
                this.formData = {...payload}
                this.image = ''
            }
        },
        message: function (props, prevProps) {
            if (props) {
                this.formMessage = props
            } else {
                this.formMessage = []
            }
        }
    }
}
</script>