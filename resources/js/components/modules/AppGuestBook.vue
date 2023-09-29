<template>
    <div id="App" :class="innerClass ? innerClass : 'width width-100 width-mobile'">
        <div :class="'theme-guest mobile box-shadow'">
            <div 
                v-if="!isEnableGuestBook"
                class="padding padding-15px bg-red">
                <div class="fonts fonts-11 semibold white align-center">
                    {{
                        enableEnglish 
                            ? 'Reservation Has Been Closed' 
                            : 'Reservasi Telah Ditutup'
                    }}
                </div>
            </div>

            <div class="theme-guest-header bg-white">
                <div class="display-flex space-between align-center">
                    <div class="fonts fonts-11 black semibold">
                        {{ 
                            title 
                                ? title 
                                : enableEnglish 
                                    ? 'Guest Book' 
                                    : 'Buku Tamu'
                        }}
                    </div>
                    <div class="display-flex">
                        <button 
                            class="btn btn-white btn-icon" 
                            @click="getData(invStringID)">
                            <i class="fa fa-lw fa-retweet"></i>
                        </button>
                        <button 
                            v-if="!disablePopupForm" 
                            class="theme-guest-add btn btn-white btn-icon" @click="onShowPopup">
                            <i class="fa fa-lw fa-plus" />
                        </button>
                    </div>
                </div>
            </div>

            <div class="display-flex display-mobile">
                <div :class="`${!disablePopupForm ? (`theme-guest-book ${visiblePopup ? 'show' : ''}`) : 'theme-guest-book-normal'} width width-40 width-mobile border-right`">
                    <div v-if="!disablePopupForm" class="theme-guest-add theme-guest-header bg-white">
                        <div class="display-flex space-between align-center">
                            <div class="fonts micro semibold">
                                {{
                                    enableEnglish 
                                        ? 'Add Guest Book' 
                                        : 'Tambah Buku Tamu'
                                }}
                            </div>
                            <button 
                                class="btn btn-icon btn-white" 
                                @click="onShowPopup">
                                <i class="fa fa-lg fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="theme-guest-body bg-white" :style="`height: 450px; padding-top: 15px; padding-bottom: 15px;`">
                        <div style="width: 100%">
                            <div class="field-group margin margin-bottom-15-px">
                                <div class="fonts micro black semibold">
                                    {{
                                        labelNameText 
                                            ? labelNameText 
                                            : enableEnglish 
                                                ? 'Name' 
                                                : 'Nama'
                                    }} <span class="fonts red">*</span>
                                </div>
                                <div 
                                    v-if="descriptionNameText" 
                                    class="fonts micro black">
                                    {{ descriptionNameText }}
                                </div>
                                <el-input 
                                    v-model="formData.name" 
                                    placeholder=""
                                    :disabled="isThereGuest || !isEnableGuestBook"></el-input>
                                <div v-if="formMessage" class="fonts micro semibold" style="color: red; margin-bottom: 5px;">
                                    {{ formMessage && formMessage.name && formMessage.name[0] }}
                                </div>
                            </div>
                            <div class="field-group margin margin-bottom-15-px">
                                <div class="fonts micro black semibold">
                                    {{
                                        labelCommentText 
                                            ? labelCommentText 
                                            : enableEnglish 
                                                ? "Leave Message" 
                                                : "Ucapan & Do'a"
                                    }}
                                </div>
                                <div 
                                    v-if="descriptionCommentText" 
                                    class="fonts micro black">
                                    {{ descriptionCommentText }}
                                </div>
                                <el-input 
                                    type="textarea"
                                    v-model="formData.comments" 
                                    placeholder=""
                                    :rows="4"
                                    :disabled="!isEnableGuestBook"></el-input>
                                <div v-if="formMessage" class="fonts micro semibold" style="color: red; margin-bottom: 10px;">
                                    {{ formMessage && formMessage.comments && formMessage.comments[0] }}
                                </div>
                            </div>
                            <div v-if="formData.present_type !== 'present'">
                                <div class="field-group margin margin-bottom-15-px">
                                    <div class="fonts micro black semibold">
                                        {{
                                            labelAttendanceText 
                                                ? labelAttendanceText 
                                                : enableEnglish 
                                                    ? 'Attendance' 
                                                    : 'Kehadiran'
                                        }} <span class="fonts red">*</span>
                                    </div>
                                    <div class="fonts micro black">
                                        {{
                                            descriptionAttendanceText
                                                ? descriptionAttendanceText
                                                : enableEnglish 
                                                    ? 'Will you attend this event ?' 
                                                    : 'Apakah kamu akan menghadiri acara ini ?'
                                        }}
                                    </div>
                                    <div class="margin margin-top-10px">
                                        <el-radio-group 
                                            v-model="formData.present_type"
                                            :disabled="!isEnableGuestBook"
                                            @change="onChangePresentType">
                                            <el-radio 
                                                :label="'will-present'">
                                                {{ enableEnglish ? 'Yes, I will present' : 'Iya, Akan hadir' }}
                                            </el-radio>
                                            <el-radio 
                                                :label="'not-present'">
                                                {{ enableEnglish ? 'Not present' : 'Tidak akan hadir' }}
                                            </el-radio>
                                        </el-radio-group>
                                    </div>
                                    <div v-if="formMessage" class="fonts micro bold" style="color: red; margin-top: 5px;">
                                        {{ formMessage && formMessage.present_type && formMessage.present_type[0] }}
                                    </div>
                                </div>
                                <div
                                    v-if="formData.present_type === 'will-present'"
                                    class="field-group margin margin-bottom-15-px">
                                    <div class="display-flex column">
                                        <div class="fonts micro black semibold">
                                            {{
                                                labelPresentText 
                                                    ? labelPresentText
                                                    : enableEnglish 
                                                        ? 'How many people will attendance ?' 
                                                        : 'Berapa orang yang akan menghadiri acara ini?'
                                            }}
                                        </div>
                                        <div 
                                            v-if="descriptionPresentText" 
                                            class="fonts micro black">
                                            {{ descriptionPresentText }}
                                        </div>
                                        <el-select 
                                            :placeholder="enableEnglish ? 'Select attendance' : 'Pilih jumlah kehadiran'"
                                            v-model="formData.attendance"
                                            :disabled="!isEnableGuestBook"
                                            style="width: 100%;">
                                            <el-option
                                                v-for="(item, index) in dataAttendance"
                                                :key="index"
                                                :label="item.label"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div v-if="formMessage" class="fonts micro bold" style="color: red; margin-top: 5px;">
                                        {{ formMessage && formMessage.attendance && formMessage.attendance[0] }}
                                    </div>
                                </div>
                            </div>
                            <div v-if="formData.present_type === 'present'">
                                <div class="fonts micro black semibold">
                                    {{
                                        labelAttendanceText 
                                            ? labelAttendanceText 
                                            : enableEnglish 
                                                ? 'Attendance Status' 
                                                : 'Status Kehadiran'
                                    }} <span class="fonts red">*</span>
                                </div>
                                <div class="display-flex">
                                    <div 
                                        v-if="formData.present_type === 'present'"
                                        :class="'card-capsule active'" 
                                        style="text-transform: capitalize;">
                                        Hadir - {{ formData.attendance }} Orang
                                    </div>
                                    <div 
                                        v-if="formData.present_type === 'will-present'"
                                        :class="'card-capsule wip'" 
                                        style="text-transform: capitalize;">
                                        Akan Hadir - {{ formData.attendance }} Orang
                                    </div>
                                    <div 
                                        v-if="formData.present_type === 'not-present'"
                                        :class="'card-capsule inactive'" 
                                        style="text-transform: capitalize;">
                                        Tidak Hadir
                                    </div>
                                    <div 
                                        v-if="formData.present_type === 'waiting-response'"
                                        :class="'card-capsule'" 
                                        style="text-transform: capitalize;">
                                        Menunggu
                                    </div>
                                </div>
                            </div>
                            <div class="display-flex right" style="padding-top: 10px;">
                                <button 
                                    v-if="!disablePopupForm"
                                    class="theme-guest-add btn btn-white" 
                                    @click="onShowPopup">
                                    {{enableEnglish ? 'Cancel' : 'Batalkan'}}
                                </button>
                                <button 
                                    v-if="isEnableGuestBook"
                                    class="btn btn-main" 
                                    :style="`background-color: ${backgroundButtonColor || ''}; border-color: ${backgroundButtonColor || ''}; color: ${textButtonColor || ''};`"
                                    :disabled="visibleLoaderAction"
                                    @click="onShowAlert">
                                    {{enableEnglish ? 'Save & Submit' : 'Simpan Data'}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="width width-60 width-mobile">
                    <div class="border-bottom bg-white">
                        <AppTabs 
                            :selectedIndex="selectedIndex" 
                            :data.sync="tabs" 
                            :isFull="true"
                            :onChange="(data) => onChangeTabs(data)" 
                            :mainColor="mainColor"
                        />
                    </div>
                    <div class="theme-guest-container">
                        <div class="theme-guest-body" :style="`height: 425px; background-color: ${backgroundChatColor || ''};`">
                            <AppLoader v-if="visibleLoader" />
                            <div v-for="(dt, i) in datas" :key="i" class="theme-guest-user">
                                <div class="theme-guest-cover">
                                    <i class="post-top fa fa-lg fa-user-circle"></i>
                                </div>
                                <div class="theme-guest-info">
                                    <div class="display-flex left align-center display-mobile" style="margin-bottom: 5px;">
                                        <div class="fonts fonts-10 black semibold" style="margin-right: 5px;">{{ dt.name }}</div>
                                        <div class="display-flex left">
                                            <div 
                                                v-if="dt.present_type === 'present'"
                                                :class="'card-capsule active'" 
                                                style="text-transform: capitalize;">
                                                Hadir - {{ dt.attendance }} Orang
                                            </div>
                                            <div 
                                                v-if="dt.present_type === 'will-present'"
                                                :class="'card-capsule wip'" 
                                                style="text-transform: capitalize;">
                                                Akan Hadir - {{ dt.attendance }} Orang
                                            </div>
                                            <div 
                                                v-if="dt.present_type === 'not-present'"
                                                :class="'card-capsule inactive'" 
                                                style="text-transform: capitalize;">
                                                Tidak Hadir
                                            </div>
                                            <div 
                                                v-if="dt.present_type === 'waiting-response'"
                                                :class="'card-capsule'" 
                                                style="text-transform: capitalize;">
                                                Menunggu
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fonts fonts-10 black" style="margin-bottom: 5px;">{{ dt.comments }}</div>
                                    <div class="fonts fonts-9 grey">{{ dt.updated_at ? dt.updated_at : dt.created_at | moment("from", "now") }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="!disablePopupForm" class="theme-guest-add theme-guest-footer">
                        <button 
                            class="btn btn-primary btn-full" 
                            @click="onShowPopup"
                            :style="`background-color: ${backgroundButtonColor || ''}; border-color: ${backgroundButtonColor || ''}; color: ${textButtonColor || ''}; cursor: not-allowed`">
                            {{enableEnglish ? 'Add Guest Book' : 'Tambah Buku Tamu'}}
                        </button>
                    </div>
                </div>
            </div> 
        </div>

        <AppGuestQRCode 
            v-if="formData.guest_id && isEnableGuestBook && formData.present_type !== 'present'"
            :invitationID="invStringID"
            :invitationShortLink="invShortLink"
            :guestID="formData.guest_id"
            :enableEnglish="enableEnglish"
            @onSave="savePresentData"
        />
        
        <AppPopupConfirmed 
            v-if="visibleAlertSave"
            :title="titleConfirmed"
            :enableEnglish="enableEnglish"
            @onClickNo="onShowAlert"
            @onClickYes="saveData"
        />

        <AppPopupAlert 
            v-if="visibleAlert"
            :title="titleAlert"
            :icon="iconAlert"
            :enableEnglish="enableEnglish"
            @onClickOk="onClickOk"
        />
        
        <AppPopupLoader 
            v-if="visibleLoaderAction"
            :title="titleLoader"
        />
    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex'
import axios from 'axios'
import AppAlert from './AppAlert'
import AppLoader from './AppLoader'
import AppTabs from './AppTabs'
import AppPopupConfirmed from './AppPopupConfirmed'
import AppPopupLoader from './AppPopupLoader'
import AppPopupAlert from './AppPopupAlert'
import AppGuestQRCode from './AppGuestQRCode'

const payload = {
    id: "",
    guest_id: "",
    name: "",
    phone: "",
    address: "",
    comments: "",
    rsvp: "",
    present_type: "not-present",
    attendance: 1,
    is_present: 1,
    status: "active",
    is_available: 1,
    invitation_id: ""
}

export default {
    name: 'App',
    data () {
        return {
            selectedIndex: 0,
            tabs: [
                {id: 1, label: 'Semua', val: '0', status: 'active'},
                {id: 2, label: 'Hadir', val: '0', status: ''},
                {id: 3, label: 'Tidak', val: '0', status: ''}
            ],
            titleLoader: 'Mohon Tunggu ...',
            titleConfirmed: 'Simpan data kamu di Buku Tamu ?',
            titleAlert: 'Data tamu sudah ditambahkan !',
            iconAlert: '',
            visibleAlert: false,
            visiblePopup: false,
            visibleLoader: false,
            visibleAlertSave: false,
            visibleLoaderAction: false,
            rawDatas: [],
            datas: [],
            formData: {...payload},
            formMessage: null 
        }
    },
    components: {
        AppLoader,
        AppAlert,
        AppTabs,
        AppPopupConfirmed,
        AppPopupLoader,
        AppPopupAlert,
        AppGuestQRCode,
    },
    mounted () {
        this.formData = {
            ...this.formData,
            name: this.guestName,
        }
        if (this.data) {
            this.formData = {
                ...this.formData,
                id: this.data.id,
                guest_id: this.data.guest_id,
                rsvp: this.data.rsvp,
                comments: this.data.comments,
                present_type: this.data.present_type,
                is_present: this.data.is_present,
                attendance: this.data.attendance,
                invitation_id: this.data.invitation_id,
            }
        }
        if (this.enableEnglish) {
            this.tabs = [
                {id: 1, label: 'All', val: '0', status: 'active'},
                {id: 2, label: 'Present', val: '0', status: ''},
                {id: 3, label: 'Absent', val: '0', status: ''}
            ]
            this.titleConfirmed = 'Save your data to Guest Book ?'
            this.titleLoader = 'Please Wait ...'
        }
        this.getData(this.invStringID)
    },
    computed: {
        ...mapState({
            dataInvitation: state => state.guestInvitation.data,
            dataPresent: state => state.customerGuests.dataPresentGuestBook,
            dataAttendance: state => state.customerGuests.dataAttendance,
        }),
        data () {
            return this.dataInvitation && this.dataInvitation.guest
        },
        guestName () {
            return this.dataInvitation && this.dataInvitation.guest && this.dataInvitation.guest.name
        },
        invitation () {
            return this.dataInvitation && this.dataInvitation.invitation
        },
        invID () {
            return this.invitation.id
        },
        invStringID () {
            return this.invitation.invitation_id
        },
        invShortLink () {
            return this.invitation.short_link
        },
        isThereGuest () {
            let status = false 
            if (this.guestName) {
                status = true
            }
            return status
        },
        isEnableGuestBook () {
            return this.invitation.is_reservation_enable
        }
    },
    methods: {
        ...mapActions({
            setToast: 'toast/setToast',
        }),
        onChangePresentType (data) {
            const isPresent = data === 'will-present' ? 1 : 0
            const attendance = data === 'will-present' ? 1 : 0
            this.formData = {
                ...this.formData,
                is_present: isPresent,
                attendance: attendance
            }
        },
        onChangeTabs (data) {
            this.selectedIndex = data
            if (data === 0) this.datas = this.getFilter(this.rawDatas, 'all')
            if (data === 1) this.datas = this.getFilter(this.rawDatas, 'will-present')
            if (data === 2) this.datas = this.getFilter(this.rawDatas, 'not-present')
        },
        makeToast (title) {
            const payload = {
                visible: true,
                title: title
            }
            this.setToast(payload)
        },
        onShowPopup () {
            this.visiblePopup = !this.visiblePopup
        },
        onShowAlert () {
            this.visibleAlertSave = !this.visibleAlertSave
        },
        onClickOk () {
            this.visibleAlert = false
        },
        openAlertPopup (title = '', icon = '') {
            this.visibleAlert = true 
            this.titleAlert = title
            this.iconAlert = icon
        },
        savePresentData () {
            this.formData.present_type = 'present'
            this.saveData()
        },
        async saveData () {
            this.visibleAlertSave = false
            this.visibleLoaderAction = true

            const time = new Date().getTime()
            const guest_id = this.formData.guest_id ? this.formData.guest_id : `GE-${time}`
            const newPayload = {
                ...this.formData,
                guest_id: guest_id,
                invitation_id: this.invID
            }
            const url = '/api/public/guestPost'

            const rest = await axios.post(url, newPayload)

            if (rest && rest.status === 200) {
                this.visibleLoaderAction = false 
                this.visiblePopup = false 

                const data = rest.data.data
                if (data.length !== 0) {
                    this.formData = {
                        ...payload, 
                        id: data.id,
                        guest_id: data.guest_id,
                        name: data.name,
                        rsvp: data.rsvp,
                        comments: data.comments,
                        present_type: data.present_type,
                        is_present: data.is_present,
                        attendance: data.attendance,
                        invitation_id: data.invitation_id,
                    }
                    this.formMessage = null 
                    this.getData(this.invStringID)
                    this.makeToast(
                        this.enableEnglish 
                            ? 'Your data has been saved' 
                            : 'Data kamu sudah tersimpan'
                    )
                } else {
                    this.formMessage = rest.data.message
                    this.visiblePopup = true  
                }
            } else {
                this.visibleLoaderAction = false
                this.openAlertPopup(
                    this.enableEnglish 
                        ? 'Failed to save your data !' 
                        : 'Data kamu gagal di simpan !',
                    'far fa-4x fa-times-circle'
                )
            }
        },
        async getData (id) {
            this.visibleLoader = true 

            const url = '/api/public/guestByInvID'
            const payload = {
                invitation_id: id 
            }
            const rest = await axios.post(url, payload)

            if (rest && rest.status === 200) {
                const data = rest.data.data 
                const total_not_present = parseInt(rest.data.total_not_present)
                const total_present = parseInt(rest.data.total_present)
                const total_will_present = parseInt(rest.data.total_will_present) + total_present
                const total_all = total_will_present + total_not_present
                this.visibleLoader = false
                this.tabs[0].val = total_all ? total_all : 0
                this.tabs[1].val = total_will_present ? total_will_present : 0
                this.tabs[2].val = total_not_present ? total_not_present : 0
                this.rawDatas = data 
                this.datas = this.getFilter(data, 'all')
                this.selectedIndex = 0
            } else {
                this.visibleLoader = false
            }
        },
        getFilter (data, value = '') {
            let payload = []
            if (value === 'all') {
                data.map((dt) => {
                    if (dt.present_type !== 'waiting-response') {
                        payload.push(dt)
                    }
                })
            }
            if (value === 'will-present') {
                data.map((dt) => {
                    if (dt.present_type === 'present' || dt.present_type === 'will-present') {
                        payload.push(dt)
                    }
                })
            }
            if (value === 'not-present') {
                data.map((dt) => {
                    if (dt.present_type === 'not-present') {
                        payload.push(dt)
                    }
                })
            }
            if (value === 'waiting') {
                data.map((dt) => {
                    if (dt.present_type === 'waiting-response') {
                        payload.push(dt)
                    }
                })
            }
            return payload
        }
    },
    props: {
        disableRSVPField: {
            type: Boolean,
            required: false 
        },
        enableEnglish: {
            type: Boolean,
            required: false 
        },
        disablePopupForm: {
            type: Boolean,
            default: false
        },
        innerClass: {
            default: null,
            required: false
        },
        backgroundChatColor: {
            default: null,
        },
        backgroundButtonColor: {
            default: null,
        },
        textButtonColor: {
            default: null,
        },
        mainColor: {
            default: null,
        },
        title: {
            default: null,
        },
        labelNameText: {
            default: null,
        },
        descriptionNameText: {
            default: null,
        },
        labelCommentText: {
            default: null,
        },
        descriptionCommentText: {
            default: null,
        },
        labelAttendanceText: {
            default: null,
        },
        descriptionAttendanceText: {
            default: null,
        },
        labelPresentText: {
            default: null,
        },
        descriptionPresentText: {
            default: null,
        },
    },
}
</script>