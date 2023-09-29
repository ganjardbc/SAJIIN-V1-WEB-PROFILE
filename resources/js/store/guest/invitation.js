import axios from 'axios'
import moment from 'moment'

const payload = {
    invitation: {
        id: "",
        invitation_id: "",
        short_link: "",
        cover: "",
        title: "",
        description: "",
        video: "",
        day: "",
        date: "",
        latitude: "",
        longitude: "",
        type: "",
        status: "",
        is_available: "",
        price: "",
        discount: "",
        total_price: "",
        payment_status: "",
        theme_id: "",
        song_id: "",
        user_id: "",
        created_by: "",
        updated_by: "",
        created_at: "",
        updated_at: "",
    },
    events: [],
    brides: [
        {
            bride: {
                id: "",
                bride_id: "",
                image: "",
                name: "",
                nick_name: "",
                about: "",
                parent: "",
                instagram_link: "",
                status: "",
                is_available: "",
                invitation_id: "",
                created_by: "",
                updated_by: "",
                created_at: "",
                updated_at: "",
            },
            parents: []
        }
    ],
    galleries: [],
    covers: [],
    comments: [],
    theme: {
        id: "",
        theme_id: "",
        image: "",
        name: "",
        description: "",
        status: "",
        is_available: "",
        category_id: "",
        created_by: "",
        updated_by: "",
        created_at: "",
        updated_at: "",
    },
    song: {
        id: "",
        song_id: "",
        song: "",
        name: "",
        description: "",
        status: "",
        is_available: "",
        category_id: "",
        created_by: "",
        updated_by: "",
        created_at: "",
        updated_at: "",
    },
    guest: null,
    specialthanks: []
}

const payloadTheme = {
    id: '',
    theme_id: '',
    name: "",
    description: "",
    status: "active",
    is_available: 0,
    category_id: ''
}

const payloadSong = {
    id: '',
    song_id: '',
    song: "",
    name: "",
    description: "",
    status: "active",
    is_available: 0,
    category_id: ''
}

const payloadPacket = {
    id: '', 
    value: '', 
    label: '', 
    description: ''
}

const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
const timeZone = ['WIB', 'WIT', 'WITA']

export default {
    namespaced: true,
    state: {
        loading: false,
        days: days,
        timeZone: timeZone,
        form: payload,
        errorMessage: {
            ...payload,
            status: '',
            is_reservation_enable: ''
        },
        data: null,
        selectedTheme: payloadTheme,
        selectedSong: payloadSong,
        selectedPacket: payloadPacket,
    },
    getters: {
        loading (state) {
            return state.loading
        },
        data (state) {
            return state.data
        },
    },
    mutations: {
        SET_LOADING (state, value) {
            state.loading = value
        },
        SET_DATA (state, value) {
            state.data = value
        },
    },
    actions: {
        onChangeActiveIndex ({ commit, state }, data) {
            state.activeIndex = data
        },
        onChangePacket ({ commit, state }, data) {
            state.selectedPacket = data 
        },
        onChangeTheme ({ commit, state }, data) {
            state.selectedTheme = data 
        },
        onChangeSong ({ commit, state }, data) {
            state.selectedSong = data 
        },
        getData ({ commit, state }, data) {
            commit('SET_LOADING', true)

            const params = {
                short_link: data.short_link,
                guest_id: data.guest_id
            }

            return axios.post('/api/public/invitationByID', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    let payload = res.data.data
                    const now = new Date()

                    // Expire Date
                    const crn_date = moment(payload.invitation.created_at).add(1, 'Y')
                    const time = new Date(crn_date).getTime() 
                    const exp_invitation_date = time - now

                    // Free Trial Date
                    const free_trial_date = moment(payload.invitation.created_at).add(7, 'd')
                    const time_free_trial = new Date(free_trial_date).getTime() 
                    const exp_free_trial_date = time_free_trial - now

                    payload = {
                        ...payload,
                        invitation: {
                            ...payload.invitation,
                            exp_invitation_date: exp_invitation_date,
                            exp_free_trial_date: exp_free_trial_date,
                        }
                    }

                    commit('SET_DATA', payload)

                    return res
                })
                .catch((e) => {
                    console.log('error', e)
                })
                .finally(() => {
                    commit('SET_LOADING', false)
                })
        },
    }
}