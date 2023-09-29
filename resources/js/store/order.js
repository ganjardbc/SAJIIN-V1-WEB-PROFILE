import axios from 'axios'

let payload = {
    all: 0,
    allAdmin: 0,
    canceled: 0,
    confirmed: 0,
    cooking: 0,
    done: 0,
    packing: 0,
    shipping: 0,
    unconfirmed: 0
}

export default {
    namespaced: true,

    state: {
        count: 0,
        all: {...payload}
    },

    getters: {
        count (state) {
            return state.count
        },
        all (state) {
            return state.all
        }
    },

    mutations: {
        SET_COUNT (state, value) {
            state.count = value
        },
        SET_ALL (state, value) {
            state.all = value
        }
    },

    actions: {
        async getCount ({ commit }, token = '') {
            return await axios.post('/api/order/getCountByStatus', {}, { headers: { Authorization: token } })
            .then((rest) => {
                const count = rest.data.data
                const newPayload = {
                    ...payload,
                    all: count.all,
                    allAdmin: count.allAdmin,
                    canceled: count.canceled,
                    confirmed: count.confirmed,
                    cooking: count.cooking,
                    done: count.done,
                    packing: count.packing,
                    shipping: count.shipping,
                    unconfirmed: count.unconfirmed
                }

                commit('SET_COUNT', count.all)
                commit('SET_ALL', newPayload)
            })
            .catch(() => {
                commit('SET_COUNT', 0)
                commit('SET_ALL', payload)
            })
        }
    }
}