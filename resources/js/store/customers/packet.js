import axios from 'axios'

export default {
    namespaced: true,
    state: {
        limit: 5,
        offset: 0,
        totalRecord: 0,
        loading: false,
        loadMore: false,
        data: [
            {id: 1, value: 'bronze', label: 'Bronze', description: 'Rp. 110.000,-'},
            {id: 2, value: 'silver', label: 'Silver', description: 'Rp. 230.000,-'},
            {id: 3, value: 'diamond', label: 'Gold', description: 'Rp. 350.000,-'},
            {id: 4, value: 'platinum', label: 'Platinum', description: 'Rp. (With Deal)'},
        ]
    },
    getters: {},
    mutations: {},
    actions: {}
}