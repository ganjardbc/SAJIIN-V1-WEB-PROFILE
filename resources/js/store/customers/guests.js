import axios from 'axios'

const defaultPayload = {
    id: "",
    guest_id: "",
    name: "",
    phone: "",
    address: "",
    comments: "",
    attendance: "",
    rsvp: "",
    is_present: "",
    status: "active",
    is_available: 0,
    invitation_id: "",
    bride_id: "",
}

const defaultPayloadMessage = {
    id: "",
    guest_id: "",
    name: "",
    phone: "",
    address: "",
    comments: "",
    attendance: "",
    present_type: "",
    rsvp: "",
    is_present: "",
    status: "",
    is_available: "",
    invitation_id: "",
    bride_id: "",
}

export default {
    namespaced: true,
    state: {
        form: defaultPayload,
        message: defaultPayloadMessage,
        limit: 5,
        offset: 0,
        totalRecord: 0,
        loading: false,
        loadMore: false,
        data: [],
        selectedData: null,
        isGridView: false,
        filter: {
            search: '',
        },
        dataPresent: [
            {
                value: 'present',
                label: 'Hadir'
            }, 
            {
                value: 'will-present',
                label: 'Akan Hadir'
            }, 
            {
                value: 'not-present',
                label: 'Tidak Hadir'
            }, 
            {
                value: 'waiting-response',
                label: 'Menunggu Response'
            },
        ],
        dataPresentGuestBook: [
            {
                value: 'will-present',
                label: 'Akan Hadir'
            }, 
            {
                value: 'not-present',
                label: 'Tidak Hadir'
            },
            {
                value: 'waiting-response',
                label: 'Menunggu Response'
            },
        ],
        dataAttendance: [
            {
                value: 1,
                label: '1 Orang'
            }, 
            {
                value: 2,
                label: '2 Orang'
            }, 
            {
                value: 3,
                label: '3 Orang'
            },
        ],
        dataGuestMetrics: [
            {
                value: 1,
                label: 'Hadir',
                quantity: 0,
            }, 
            {
                value: 2,
                label: 'Akan Hadir',
                quantity: 0,
            }, 
            {
                value: 3,
                label: 'Tidak Hadir',
                quantity: 0,
            }, 
            {
                value: 4,
                label: 'Menunggu',
                quantity: 0,
            },
        ],
        bride: {
            limit: 5,
            offset: 0,
            totalRecord: 0,
            loading: false,
            loadMore: false,
            data: [],
            filter: {
                search: '',
            },
        }
    },
    getters: {
        loading (state) {
            return state.loading
        },
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
        },
        SET_MESSAGE_DATA (state, value) {
            if (value) {
                state.message = value 
            } else {
                state.message = defaultPayloadMessage 
            }
        },
        SET_FORM_DATA (state, value) {
            if (value) {
                state.form = value
            } else {
                const time = new Date().getTime()
                state.form = {
                    ...defaultPayload,
                    guest_id: `GE-${time}`,
                    status: 'active',
                }
            }
        },
        SET_TOTAL_RECORD (state, value) {
            state.totalRecord = value
        },
        SET_GUEST_METRICS (state, value) {
            state.dataGuestMetrics[0].quantity = value.total_present
            state.dataGuestMetrics[1].quantity = value.total_will_present
            state.dataGuestMetrics[2].quantity = value.total_not_present
            state.dataGuestMetrics[3].quantity = value.total_waiting_response
        },

        // BRIDE
        SET_BRIDE_LOADING (state, value) {
            state.bride.loading = value
        },
        SET_BRIDE_LOAD_MORE (state, value) {
            state.bride.loadMore = value
        },
        SET_BRIDE_OFFSET (state, value) {
            state.bride.offset += value
        },
        SET_BRIDE_DATA (state, value) {
            state.bride.data = value
        },
        SET_BRIDE_TOTAL_RECORD (state, value) {
            state.bride.totalRecord = value
        },
    },
    actions: {
        onChangeGridView ({ commit, state }, value) {
            state.isGridView = value
        },
        setPagination ({ commit, state }, data) {
            state.offset = (data - 1) * state.limit
        },
        setFormData ({ commit, state }, data) {
            commit('SET_FORM_DATA', data)
        },
        resetFormData ({ commit, state }) {
            commit('SET_FORM_DATA', null)
            commit('SET_MESSAGE_DATA', null)
        },
        resetFilter ({ commit, state }) {
            state.limit = 5
            state.offset = 0
        },
        resetSelectedData ({ commit, state }) {
            state.selectedData = null 
        },
        getData ({ commit, state }, data) {
            commit('SET_LOADING', true)
            commit('SET_LOAD_MORE', false)

            let dataPrev = []

            const params = {
                limit: state.limit,
                offset: state.offset,
                search: state.filter.search,
                invitation_id: data.id,
                bride_id: data.bride_id,
                present_type: data.present_type
            }

            return axios.post('/api/guest/getAll', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    const payload = res.data.data 

                    payload && payload.map((dt) => {
                        dataPrev.push({ ...dt })
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
                guest_id: data.guest_id
            }

            return axios.post('/api/guest/getByID', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    const payload = res.data.data

                    commit('SET_SELECTED_DATA', payload)

                    return res
                })
                .catch((e) => {
                    console.log('error', e)
                })
                .finally(() => {
                    commit('SET_LOADING', false)
                })
        },
        getQuantity ({ commit, state }, data) {
            commit('SET_LOADING', true)

            const params = {
                limit: state.limit,
                offset: state.offset,
                invitation_id: data.id
            }

            return axios.post('/api/guest/getQuantity', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    const payload = res.data.data 

                    commit('SET_GUEST_METRICS', payload)

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
                ...data
            }

            return axios.post('/api/guest/post', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    const data = res.data 
                    if (data.status === 'ok') {
                        commit('SET_MESSAGE_DATA', data.message)
                    } else {
                        commit('SET_MESSAGE_DATA', data.message)
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
                ...data
            }

            return axios.post('/api/guest/update', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    const data = res.data 
                    if (data.status === 'ok') {
                        commit('SET_MESSAGE_DATA', data.message)
                    } else {
                        commit('SET_MESSAGE_DATA', data.message)
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
        deleteData ({ commit, state }, data) {
            commit('SET_LOADING', true)
            
            const params = {
                ...data
            }

            return axios.post('/api/guest/delete', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    return res
                })
                .catch((e) => {
                    console.log('error', e)
                })
                .finally(() => {
                    commit('SET_LOADING', false)
                })
        },

        // BRIDE
        getDataBride ({ commit, state }, data) {
            commit('SET_BRIDE_LOADING', true)
            commit('SET_BRIDE_LOAD_MORE', false)

            let dataPrev = []
            const params = {
                limit: state.bride.limit,
                offset: state.bride.offset,
                search: state.bride.filter.search,
                invitation_id: data.id
            }

            return axios.post('/api/bride/getAll', params, { 
                    headers: { Authorization: data.token } 
                })
                .then((res) => {
                    const payload = res.data.data 

                    payload && payload.map((dt) => {
                        dataPrev.push({ ...dt })
                    })

                    commit('SET_BRIDE_DATA', dataPrev)
                    commit('SET_BRIDE_TOTAL_RECORD', res.data.total_record)

                    if (payload.length < state.bride.limit) {
                        commit('SET_BRIDE_LOAD_MORE', false)
                    } else {
                        commit('SET_BRIDE_LOAD_MORE', true)
                    }

                    return res
                })
                .catch((e) => {
                    console.log('error', e)
                })
                .finally(() => {
                    commit('SET_BRIDE_LOADING', false)
                })
        },
    }
}