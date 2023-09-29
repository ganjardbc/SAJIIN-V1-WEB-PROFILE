import axios from 'axios'

const defaultPayload = {
    id: "",
    gallery_id: "",
    description: "",
    status: "active",
    is_available: 0,
    invitation_id: ""
}

const defaultPayloadMessage = {
    id: "",
    gallery_id: "",
    description: "",
    status: "",
    is_available: 0,
    invitation_id: ""
}

export default {
    namespaced: true,
    state: {
        form: defaultPayload,
        message: defaultPayloadMessage,
        limit: 8,
        offset: 0,
        totalRecord: 0,
        loading: false,
        loadMore: false,
        data: [],
        isGridView: false,
        filter: {
            search: '',
        },
        dataType: [
            {
                value: 'cover',
                label: 'Cover'
            }, 
            {
                value: 'gallery',
                label: 'Gallery'
            },
        ],
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
                    gallery_id: `EV-${time}`,
                    status: 'active',
                }
            }
        },
        SET_TOTAL_RECORD (state, value) {
            state.totalRecord = value
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
            state.limit = 8
            state.offset = 0
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
                type: data.type
            }

            return axios.post('/api/gallery/getAll', params, { 
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
        createData ({ commit, state }, data) {
            commit('SET_LOADING', true)
            
            const params = {
                ...data
            }

            return axios.post('/api/gallery/post', params, { 
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

            return axios.post('/api/gallery/update', params, { 
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

            return axios.post('/api/gallery/delete', params, { 
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
        uploadCover ({ commit, state }, data) {
            commit('SET_LOADING', true)
    
            let params = new FormData()
            params.append('gallery_id', data.gallery_id)
            params.append('image', data.image)
    
            return axios.post('/api/gallery/uploadImage', params, { 
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
    }
}