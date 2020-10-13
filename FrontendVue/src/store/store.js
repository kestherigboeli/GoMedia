import axios from 'axios'

const state = {
    token: null,
    user: null,
    products: {}
};

const getters = {
    authenticated(state) {
        return state.token && state.user
    },

    user(state) {
        return state.user
    },

    products(state) {
        return state.products
    }
};


const mutations = {

    SET_TOKEN(state, token) {
        state.token = token
    },

    SET_USER(state, data) {
        state.user = data
    },

    SET_PRODUCT(state, data) {
        state.products = data
    }
};

const actions = {

   async signIn( { dispatch, commit}, credentials) {
       let response = await axios.post('/auth/login', credentials);

       return dispatch('attempt', response.data.access_token)
    },

    async attempt ( { commit, state }, token) {
       
       if (token) {
           commit('SET_TOKEN', token)
       }

       if (!state.token) {
           return
       }

        try {

            let response = await axios.get('/auth/me', {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            commit('SET_USER', response.data)
            localStorage.setItem('token', token)

        } catch (e) {
           commit('SET_TOKEN', null)
           commit('SET_USER', null)
        }
    },

    signOut( {commit}, token ) {
       return axios.post('/auth/logout', {
           headers: {
               'Authorization': 'Bearer ' + token
           }
       }
       )
           .then( () => {
               commit('SET_TOKEN', null)
               commit('SET_USER', null)
           })
    },

    async getProducts( {commit}) {

         await axios.get("/auth/products")
             .then(response => {
                 console.log(response.data.products);
                 commit('SET_PRODUCT', response.data.products)
             })

    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
}