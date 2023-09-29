import axios from 'axios'

export default {
    namespaced: true,
    state: {
        limit: 5,
        offset: 0,
        totalRecord: 0,
        loading: false,
        loadMore: false,
        data: []
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
        SET_TOTAL_RECORD (state, value) {
            state.totalRecord = value
        },
    },
    actions: {
        resetFilter ({ commit, state }) {
            state.limit = 5
            state.offset = 0
        },
        setPagination ({ commit, state }, data) {
            state.offset = (data - 1) * state.limit
        },
        getData ({ commit, state }, data) {
            commit('SET_LOADING', true)
            commit('SET_LOAD_MORE', false)

            let dataPrev = []

            const params = {
                limit: state.limit,
                offset: state.offset,
                status: 'active'
            }

            return axios.post('/api/theme/getAll', params, { 
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
        }
    }
}