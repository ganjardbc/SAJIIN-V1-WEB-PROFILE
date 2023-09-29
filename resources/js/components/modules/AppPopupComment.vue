<template>
    <div id="App">
        <button v-if="!isMobileView" class="theme-comment-button btn btn-main btn-icon btn-small-radius box-shadow" @click="openPopup">
            <i class="fa fa-lg fa-comments" />
            <div class="notif">{{ datas.length }}</div>
        </button>

        <div :class="'theme-comment ' + (!visiblePopup ? 'hide' : '') + (isMobileView ? ' mobile' : '')">
            <div class="theme-comment-header">
                <div class="display-flex space-between">
                    <div class="">
                        <div class="post-top display-flex">
                            <div style="margin-right: 10px;">
                                <div class="post-top fonts fonts-11 black semibold">
                                    Ucapan & Do'a
                                </div>
                            </div>
                            <div class="theme-notif">
                                <div class="label fonts fonts-10 white">
                                    {{ datas.length }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="display-flex">
                        <button class="btn btn-main btn-icon" @click="getData(invID)">
                            <i class="fa fa-lg fa-retweet"></i>
                        </button>
                        <button class="theme-button-collapse btn btn-main btn-icon" @click="openPopup">
                            <i v-if="!visiblePopup" class="fa fa-lg fa-chevron-down"></i>
                            <i v-else class="fa fa-lg fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="theme-comment-container">
                <div class="theme-comment-body">
                    <AppLoader v-if="visibleLoader" />
                    <div v-for="(dt, i) in datas" :key="i" class="theme-comment-user">
                        <div class="theme-comment-cover">
                            <i class="post-top fa fa-lg fa-user-circle"></i>
                        </div>
                        <div class="theme-comment-info">
                            <div class="display-flex" style="margin-bottom: 5px;">
                                <div>
                                    <div class="post-top fonts fonts-10 black semibold">{{ dt.name }}</div>
                                </div>
                                <div class="card-capsule active" style="margin-left: 15px;">
                                    Hadir 
                                </div>
                            </div>
                            <div class="fonts fonts-10 black" style="margin-bottom: 5px;">{{ dt.comment }}</div>
                            <div class="fonts fonts-9 grey">{{ dt.created_at | moment("from", "now") }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="theme-comment-footer">
                <div v-if="!visibleForm">
                    <button class="btn btn-main btn-full" @click="openForm">Beri Ucapan atau Do'a</button>
                </div>
                <div v-else class="theme-comment-form">
                    <input 
                        type="text" 
                        name="name" 
                        class="field field-sekunder" 
                        placeholder="Nama" 
                        v-model="formData.name"
                        :readonly="visibleLoaderAction"
                        style="margin-bottom: 5px;">
                    <div v-if="formMessage" class="fonts fonts-10" style="color: red; margin-bottom: 5px;">
                        {{ formMessage && formMessage.name && formMessage.name[0] }}
                    </div>
                    <textarea 
                        name="comment" 
                        id="comment" 
                        class="field field-sekunder field-textarea" 
                        placeholder="Ketik ucapan atau do'a .." 
                        v-model="formData.comment"
                        :readonly="visibleLoaderAction"
                        style="margin-bottom: 5px; margin-top: 5px;"></textarea>
                    <div v-if="formMessage" class="fonts fonts-10" style="color: red; margin-bottom: 10px;">
                        {{ formMessage && formMessage.comment && formMessage.comment[0] }}
                    </div>
                    <div class="display-flex space-between">
                        <div></div>
                        <div class="display-flex">
                            <button v-if="!visibleLoaderAction" class="btn btn-grey" style="margin-right: 5px;" @click="openForm">Gak Jadi</button>
                            <button v-if="!visibleLoaderAction" class="btn btn-main" @click="onShowAlert">Kirim</button>
                            <button v-else class="btn btn-grey" style="cursor: not-allowed;">Kirim ucapan atau do'a ..</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <AppAlert 
            v-if="visibleAlertSave" 
            :isLoader="visibleLoaderAction"
            :title="'Kirim ucapan & do\'a ?'" 
            :onClose="onShowAlert" 
            :onSave="onSave" />
    </div>
</template>
<script>
import { mapActions } from 'vuex'
import axios from 'axios'
import AppLoader from './AppLoader'
import AppAlert from './AppAlert'

const payload = {
    id: "",
    comment_id: "",
    name: "",
    comment: "",
    status: "active",
    is_available: 0,
    invitation_id: ""
}

export default {
    name: 'App',
    data () {
        return {
            isMobileView: true,
            visibleAlertSave: false,
            visiblePopup: false,
            visibleForm: false,
            visibleLoader: false,
            visibleLoaderAction: false,
            formData: {...payload},
            formMessage: [],
            datas: []
        }
    },
    mounted () {
        this.formData = {
            ...payload,
            name: this.guest
        }
        
        this.getData(this.invID)
    },
    components: {
        AppAlert,
        AppLoader
    },
    props: {
        guest: {
            required: false
        },
        invID: {
            reuqired: true 
        }
    },
    methods: {
        ...mapActions({
            setToast: 'toast/setToast',
        }),
        makeToast (title) {
            const payload = {
                visible: true,
                title: title
            }
            this.setToast(payload)
        },
        onShowAlert () {
            this.visibleAlertSave = !this.visibleAlertSave
        },
        openPopup () {
            this.visiblePopup = !this.visiblePopup
        },
        openForm () {
            this.visibleForm = !this.visibleForm
        },
        async onSave () {
            this.visibleLoaderAction = true 

            const time = new Date().getTime()
            const newPayload = {
                ...this.formData,
                comment_id: "FE-" + time,
                invitation_id: this.invID
            }
            const url = '/api/public/commentPost'

            const rest = await axios.post(url, newPayload)

            if (rest && rest.status === 200) {
                this.visibleLoaderAction = false
                this.visibleAlertSave = false

                const data = rest.data.data
                if (data.length !== 0) {
                    this.formData = {...payload, name: this.guest}
                    this.openForm()
                    this.makeToast("Ucapan & do'a terkirim")
                    this.getData(this.invID)
                } else {
                    this.formMessage = rest.data.message
                }
            } else {
                alert('Proceed failed')
                this.visibleLoaderAction = false
            }
        },
        async getData (id) {
            this.visibleLoader = true 

            const url = '/api/public/commentByInvID'
            const payload = {
                invitation_id: id 
            }
            const rest = await axios.post(url, payload)

            if (rest && rest.status === 200) {
                const data = rest.data.data 
                this.datas = data 
                this.visibleLoader = false
            } else {
                console.log('invitation empty')
                this.visibleLoader = false
            }
        }
    },
    watch: {
        guest: function (props) {
            if (props) {
                this.formData = {
                    ...this.formData,
                    name: props 
                }
            }
        },
        invID: function (props) {
            if (props) {
                this.getData(props)
            }
        }
    }
}
</script>