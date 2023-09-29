<template>
    <div id="App">
        <div class="width width-280px width-center padding padding-top-30px">
            <div class="card bg-white box-shadow content-center" style="border-radius: 5px;">
                <vue-qrcode 
                    :width="230"
                    :value="`${initUrl}/${invitationShortLink}/${guestID}`" />
                <div class="fonts micro black align-center margin margin-top-15px">
                    {{
                        enableEnglish 
                            ? 'Save this QR-Code With Screen Shoot This Section' 
                            : 'Simpan Kode QR Dengan Screen Shoot Bagian Ini'
                    }}
                </div>
                <div class="fonts micro black align-center margin margin-top-5px">
                    {{
                        enableEnglish 
                            ? 'and' 
                            : 'dan'
                    }}
                </div>
                <div class="fonts micro black align-center margin margin-top-5px">
                    {{
                        enableEnglish 
                            ? 'Show This QR-Code To The Committee When Attending This Event.' 
                            : 'Tunjukan Kepada Panitia Saat Menghadiri Acara Nanti.'
                    }}
                </div>
                <!-- <div class="display-flex center margin margin-top-15px">
                    <button class="btn btn-sekunder" @click="onOpen">
                        <i class="icn icn-left fa fa-lg fa-qrcode"></i>
                        {{
                            enableEnglish 
                                ? 'Scan QR Invitation' 
                                : 'Scan QR Undangan'
                        }}
                    </button>
                </div> -->
            </div>
        </div>

        <div v-if="visibleQRScanner" class="display-popup">
            <div class="post-middle-absolute width width-400px width-mobile">
                <div class="padding padding-15px">
                    <div class="card box-shadow bg-white">
                        <div class="display-flex space-between align-center margin margin-bottom-15px">
                            <div class="fonts fonts-11 semibold black">
                                {{
                                    enableEnglish 
                                        ? 'Scan QR Invitation' 
                                        : 'Scan QR Undangan'
                                }}
                            </div>
                            <button class="btn btn-white btn-icon" @click="onClose">
                                <i class="fa fa-lg fa-times"></i>
                            </button>
                        </div>
                        <div v-if="!selectedInvitationID" class="width width-100">
                            <qrcode-stream 
                                @decode="onDecode" 
                                @init="onInit">
                                <div v-if="loading" class="post-middle-absolute">
                                    <AppLoader :title="enableEnglish ? 'Please Wait' : 'Mohon Tunggu'" />
                                </div>
                            </qrcode-stream>
                            <div class="margin margin-top-15px">
                                <div class="fonts fonts-11 align-center normal black">
                                    {{
                                        enableEnglish 
                                            ? 'Scan The QR-Code That Committee Has Been Set in This Event.' 
                                            : 'Scan Kode QR Yang Sudah Panitia Sediakan di Acara Ini.'
                                    }}
                                </div>
                            </div>
                        </div>
                        <div v-if="selectedInvitationID">
                            <div v-if="selectedInvitationID === invitationID" class="padding padding-30px">
                                <div class="display-flex column align-center">
                                    <i class="fonts fonts-64 primary far fa-4x fa-question-circle"></i>
                                    <div class="fonts fonts-12 semibold black align-center margin margin-top-30px">
                                        {{
                                            enableEnglish 
                                                ? 'Invitation Found.' 
                                                : 'Data Undangan Ditemukan.'
                                        }}
                                    </div>
                                    <div class="fonts fonts-12 normal black align-center margin margin-bottom-30px">
                                        {{
                                            enableEnglish 
                                                ? 'Change your present status to "Present" ?' 
                                                : 'Ubah status kehadiran kamu menjadi "Hadir" ?'
                                        }}
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
                            <div v-else class="padding padding-30px">
                                <div class="display-flex column align-center">
                                    <i class="fonts fonts-64 primary fa fa-4x fa-info-circle"></i>
                                    <div class="fonts fonts-12 semibold black align-center margin margin-top-30px margin-bottom-30px">
                                        {{
                                            enableEnglish 
                                                ? 'Invitation Not Found.' 
                                                : 'Data Undangan Tidak Ditemukan.'
                                        }}
                                    </div>
                                    <button 
                                        class="btn btn-full btn-sekunder"
                                        @click="resetSelectedInvitationID">
                                        {{
                                            enableEnglish 
                                                ? 'Rescan QR-Code.' 
                                                : 'Scan Ulang Kode QR.'
                                        }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueQrcode from 'vue-qrcode'
import AppLoader from './AppLoader'

export default {
    name: 'App',
    data () {
        return {
            visibleQRScanner: false,
            selectedInvitationID: null,
            loading: false,
        }
    },
    components: {
        VueQrcode,
        AppLoader
    },
    props: {
        invitationID: null,
        invitationShortLink: null,
        guestID: null,
        enableEnglish: false,
    },
    methods: {
        resetSelectedInvitationID () {
            this.selectedInvitationID = null 
        },
        onOpen () {
            this.selectedInvitationID = null 
            this.visibleQRScanner = true
        },
        onClose () {
            this.visibleQRScanner = false
        },
        onDecode (result) {
            const payload = JSON.parse(result)
            this.selectedInvitationID = payload.invitationId
        },
        async onInit (promise) {
            this.loading = true
            try {
                await promise
            } catch (error) {
                if (error.name === 'NotAllowedError') {
                    this.error = "ERROR: you need to grant camera access permisson"
                } else if (error.name === 'NotFoundError') {
                    this.error = "ERROR: no camera on this device"
                } else if (error.name === 'NotSupportedError') {
                    this.error = "ERROR: secure context required (HTTPS, localhost)"
                } else if (error.name === 'NotReadableError') {
                    this.error = "ERROR: is the camera already in use?"
                } else if (error.name === 'OverconstrainedError') {
                    this.error = "ERROR: installed cameras are not suitable"
                } else if (error.name === 'StreamApiNotSupportedError') {
                    this.error = "ERROR: Stream API is not supported in this browser"
                }
            } finally {
                this.loading = false
            }
        },
        onClickNo () {
            this.selectedInvitationID = null 
            this.visibleQRScanner = false 
        },
        onClickYes () {
            this.selectedInvitationID = null 
            this.visibleQRScanner = false 
            this.$emit('onSave')
        }
    }
}
</script>