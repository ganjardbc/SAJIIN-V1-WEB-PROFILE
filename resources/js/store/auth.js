import axios from 'axios'

export default {
  namespaced: true,

  state: {
    authenticated: false,
    user: null,
    role: null,
    permissions: null,
    token: null
  },

  getters: {
    authenticated (state) {
      return state.authenticated
    },

    user (state) {
      return state.user
    },

    role (state) {
      return state.role
    },

    permissions (state) {
      return state.permissions
    },

    token (state) {
      return state.token
    },
  },

  mutations: {
    SET_AUTHENTICATED (state, value) {
      state.authenticated = value
    },

    SET_USER (state, value) {
      state.user = value
    },

    SET_ROLE (state, value) {
      state.role = value
    },

    SET_PERMISSIONS (state, value) {
      state.permissions = value
    },

    SET_TOKEN (state, value) {
      state.token = value
    }
  },

  actions: {
    token ({ commit }, token) {
      commit('SET_TOKEN', token)
    },

    setCookieAuth ({commit}, data) {
      // console.log('setCookieAuth', data)

      const AuthStr = 'Bearer '.concat(data.token)
      const permissions = data ? {permissions: [...data.permissions]} : null 

      $cookies.set('authenticated', true)
      $cookies.set('token', data.token)
      $cookies.set('user', data.user)
      $cookies.set('role', data.role)
      $cookies.set('permissions', permissions)
      $cookies.set('rawUser', data)

      commit('SET_AUTHENTICATED', true)
      commit('SET_USER', data && data.user)
      commit('SET_ROLE', data && data.role)
      commit('SET_PERMISSIONS', data && data.permissions)
      commit('SET_TOKEN', AuthStr)
    },

    removeCookieAuth ({commit}) {
      // console.log('removeCookieAuth')

      $cookies.set('authenticated', false)
      $cookies.remove('token')
      $cookies.remove('user')
      $cookies.remove('role')
      $cookies.remove('permissions')
      $cookies.remove('rawUser')
      $cookies.remove('orderItem')

      commit('SET_AUTHENTICATED', false)
      commit('SET_USER', null)
      commit('SET_ROLE', null)
      commit('SET_PERMISSIONS', null)
      commit('SET_TOKEN', null)
    },

    async register ({ dispatch }, credentials) {
      const csrf = await axios.get('/sanctum/csrf-cookie')
      const rest = await axios.post('/api/auth/register', credentials)

      // console.log('csrf', csrf)
      // console.log('rest', rest)

      return rest
    },

    async signIn ({ dispatch }, credentials) {
      const csrf = await axios.get('/sanctum/csrf-cookie')
      const rest = await axios.post('/api/auth/login', credentials)

      // console.log('csrf', csrf)

      dispatch('token', rest.data.data.token)
      dispatch('me', rest.data.data.token)

      return rest
    },
  
    async signOut ({ dispatch }, token = '') {
      const rest = await axios.post('/api/logout', {token: token} , { headers: { Authorization: token } })

      return rest
    },
    
    async me ({ commit }, token = '') {
      if (token) {
        const AuthStr = 'Bearer '.concat(token)
        const response = await axios.get('/api/me', { headers: { Authorization: AuthStr } })
        if (response) {
          const data = response.data.data
          const permissions = data ? {permissions: [...data.permissions]} : null 
          // console.log('vuex register', data)
          commit('SET_AUTHENTICATED', true)
          commit('SET_USER', data && data.user)
          commit('SET_ROLE', data && data.role)
          commit('SET_PERMISSIONS', data && data.permissions)
          commit('SET_TOKEN', AuthStr)

          $cookies.set('permissions', permissions)
        } else {
          // console.log('vuex unregister')
          commit('SET_AUTHENTICATED', false)
          commit('SET_USER', null)
          commit('SET_ROLE', null)
          commit('SET_PERMISSIONS', null)
          commit('SET_TOKEN', null)

          $cookies.remove('permissions')
        }
      }
    }
  }
}