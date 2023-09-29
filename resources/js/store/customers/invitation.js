import axios from 'axios'
import moment from 'moment'

const payload = {
    id: "",
    invitation_id: "",
    short_link: "",
    title: "",
    description: "",
    note: "",
    day: "",
    date: "",
    time: "",
    time_zone: "",
    latitude: "",
    longitude: "",
    video: "",
    video_link: "",
    type: "",
    tag: "",
    status: "active",
    is_available: 0,
    is_free_trial: 1,
    is_reservation_enable: 1,
    theme_id: "",
    song_id: "",
    price: 0,
    discount: 0,
    total_price: 0,
    payment_status: 0,
    category_id: "",
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
        limit: 6,
        offset: 0,
        totalRecord: 0,
        activeIndex: 0,
        loading: false,
        loadMore: false,
        days: days,
        timeZone: timeZone,
        form: payload,
        errorMessage: {
            ...payload,
            status: '',
            is_reservation_enable: ''
        },
        data: [],
        selectedData: payload,
        selectedRaw: null,
        selectedTheme: payloadTheme,
        selectedSong: payloadSong,
        selectedPacket: payloadPacket,
        filter: {
            search: ''
        }
    },
    getters: {
        loading (state) {
            return state.loading
        },
        selectedData (state) {
            return state.selectedData
        },
        selectedRaw (state) {
            return state.selectedRaw
        }
    },
    mutations: {
        SET_LOADING (state, value) {
            state.loading = value
        },
        SET_LOAD_MORE (state, value) {
            state.loadMore = value
        },
        SET_OFFSET (state, value) {
            state.offset += value
        },
        SET_DATA (state, value) {
            state.data = value
        },
        SET_SELECTED_DATA (state, value) {
            state.selectedData = value
            state.form = {
                ...state.form,
                id: value.id,
                invitation_id: value.invitation_id,
                short_link: value.short_link,
                title: value.title,
                description: value.description,
                note: value.note,
                day: value.day,
                date: value.date,
                time: value.time,
                time_zone: value.time_zone,
                latitude: value.latitude,
                longitude: value.longitude,
                video: value.video,
                video_link: value.video_link,
                tag: value.tag,
                type: value.type,
                status: value.status,
                is_available: value.is_available,
                is_free_trial: value.is_free_trial,
                is_reservation_enable: value.is_reservation_enable,
                theme_id: value.theme_id,
                song_id: value.song_id,
                price: value.price,
                discount: value.discount,
                total_price: value.total_price,
                payment_status: value.payment_status,
                category_id: value.category_id,
            }
        },
        SET_SELECTED_RAW (state, value) {
            state.selectedRaw = value
        },
        SET_TOTAL_RECORD (state, value) {
            state.totalRecord = value
        },
        SET_MESSAGE_DATA (state, value) {
            if (value) {
                state.errorMessage = value 
            } else {
                state.errorMessage = payload 
            }
        },
        SET_FORM_DATA (state, value) {
            if (value) {
                state.form = value
            } else {
                const time = new Date().getTime()
                state.form = {
                    ...payload,
                    invitation_id: `INV-${time}`,
                    status: 'active',
                }
            }
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
        setFormData ({ commit, state }, data) {
            commit('SET_FORM_DATA', data)
        },
        getData ({ commit, state }, data) {
            commit('SET_LOADING', true)
            commit('SET_LOAD_MORE', false)

            let dataPrev = []

            const params = {
                limit: state.limit,
                offset: state.offset,
                search: state.filter.search
            }

            if (data.role !== 'admin') {
                params.user_id = data.id 
            }

            return axios.post('/api/invitation/getAll', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    const payload = res.data.data
                    
                    payload && payload.map((dt) => {
                        const now = new Date();

                        // Expire Date
                        const crn_date = moment(dt.invitation.created_at).add(1, 'Y')
                        const time = new Date(crn_date).getTime() 
                        const exp_date = time - now

                        // Free Trial Date
                        const free_trial_date = moment(dt.invitation.created_at).add(7, 'd')
                        const time_free_trial = new Date(free_trial_date).getTime() 
                        const exp_free_trial_date = time_free_trial - now
                        dataPrev.push({
                            ...dt, 
                            invitation: {
                                ...dt.invitation, 
                                exp_date: exp_date,
                                exp_free_trial_date: exp_free_trial_date,
                            }
                        })
                    })

                    commit('SET_DATA', dataPrev)
                    commit('SET_TOTAL_RECORD', res.data.total_record)

                    if (payload.length < state.limit) {
                        commit('SET_LOAD_MORE', false)
                    } else {
                        commit('SET_LOAD_MORE', true)
                    }

                    return res
                })
                .catch((e) => {
                    console.log('error', e)
                })
                .finally(() => {
                    commit('SET_LOADING', false)
                })
        },
        getByID ({ commit, state }, data) {
            commit('SET_LOADING', true)

            const params = {
                invitation_id: data.id 
            }

            return axios.post('/api/invitation/getByID', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    let raw = res.data && res.data.data
                    let payload = raw && raw.invitation
                    const now = new Date();

                    // Expire Date
                    const crn_date = moment(payload.created_at).add(1, 'Y')
                    const time = new Date(crn_date).getTime() 
                    const exp_date = time - now

                    // Free Trial Date
                    const free_trial_date = moment(payload.created_at).add(7, 'd')
                    const time_free_trial = new Date(free_trial_date).getTime() 
                    const exp_free_trial_date = time_free_trial - now
                    payload = {
                        ...payload,
                        exp_date: exp_date,
                        exp_free_trial_date: exp_free_trial_date,
                    }

                    commit('SET_SELECTED_DATA', payload)
                    commit('SET_SELECTED_RAW', {
                        ...raw,
                        invitation: {
                            ...payload
                        }
                    })

                    return res
                })
                .catch((e) => {
                    console.log('error', e)
                })
                .finally(() => {
                    commit('SET_LOADING', false)
                })
        },
        createData ({ commit, state }, data) {
            commit('SET_LOADING', true)

            const params = {
                ...state.form
            }

            return axios.post('/api/invitation/post', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    if (res.data.status === 'invalide') {
                        commit('SET_MESSAGE_DATA', res.data.message)
                    }
                    return res
                })
                .catch((e) => {
                    console.log('error', e)
                })
                .finally(() => {
                    commit('SET_LOADING', false)
                })
        },
        updateData ({ commit, state }, data) {
            commit('SET_LOADING', true)

            const params = {
                ...state.form
            }

            return axios.post('/api/invitation/update', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    if (res.data.status === 'invalide') {
                        commit('SET_MESSAGE_DATA', res.data.message)
                    }
                    return res
                })
                .catch((e) => {
                    console.log('error', e)
                })
                .finally(() => {
                    commit('SET_LOADING', false)
                })
        },
        uploadCover ({ commit, state }, data) {
            commit('SET_LOADING', true)

            let params = new FormData()
            params.append('invitation_id', data.id)
            params.append('cover', data.cover)

            return axios.post('/api/invitation/uploadImage', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    if (res.data.status === 'invalide') {
                        commit('SET_MESSAGE_DATA', res.data.message)
                    }
                    return res
                })
                .catch((e) => {
                    console.log('error', e)
                })
                .finally(() => {
                    commit('SET_LOADING', false)
                })
        },
        resetForm ({ commit, state }) {
            state.form = payload
            state.activeIndex = 0
        },
        resetFilter ({ commit, state }) {
            state.data = []
            state.limit = 6
            state.offset = 0
        },
        setPagination ({ commit, state }, data) {
            state.offset = (data - 1) * state.limit
        },
    }
}