import axios from 'axios'

let payload = {
    all: 0,
    allAdmin: 0
}

export default {
    namespaced: true,

    state: {
        count: 0,
        data: null,
        all: {...payload}
    },

    getters: {
        count (state) {
            return state.count
        },
        data (state) {
            return state.data 
        },
        all (state) {
            return state.all
        }
    },

    mutations: {
        SET_COUNT (state, value) {
            state.count = value
        },
        SET_DATA (state, value) {
            state.data = value
        },
        SET_ALL (state, value) {
            state.all = value
        }
    },

    actions: {
        async setData ({ commit }, data = null) {
            commit('SET_DATA', data)
        },
        async getCount ({ commit }, token = '') {
            return await axios.post('/api/cart/getCountAll', {}, { headers: { Authorization: token } })
            .then((rest) => {
                const count = rest.data.data
                commit('SET_COUNT', count.all)
                commit('SET_ALL', count)
            })
            .catch(() => {
                commit('SET_COUNT', 0)
                commit('SET_ALL', payload)
            })
        }
    }
}