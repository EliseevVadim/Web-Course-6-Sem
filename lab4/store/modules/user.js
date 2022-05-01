import Axios from "axios";

const state = {
    user: {
        name: "",
        apiKey: ""
    }
};
const getters = {
    USER: state => {
        return state.user.apiKey;
    }
};
const mutations = {
    setApiKey: function (state, apiKey) {
        state.user.apiKey = apiKey;
        localStorage.setItem('apiKey', apiKey);
    },
    removeApiKey: function (state, apiKey) {
        state.user.apiKey = "";
    },
    setName: function (state, name) {
        state.user.name = name;
    },
    removeName: function (state, name) {
        state.user.name = "";
    }
};
const actions = {
    login: function (context, authData) {
        let formData = new FormData();
        formData.append('email', authData.email);
        formData.append('password', authData.password);
        return new Promise((resolve, reject) => {
            axios.post('api/login', formData)
                .then(response => {
                    context.commit('setName', response.data.data.name);
                    context.commit('setApiKey', response.data.data.token);
                    localStorage.setItem('user_id', response.data.data.id);
                    localStorage.setItem('cart_id', response.data.data.cart_id);
                    window.location.href = '/home';
                })
                .catch(error => {
                    reject(error);
                })
        })
    },
    register: function (context, userData) {
        let formData = new FormData();
        formData.append('email', userData.email);
        formData.append('name', userData.name);
        formData.append('password', userData.password);
        formData.append('confirm_password', userData.confirm_password);
        return new Promise((resolve, reject) => {
            axios.post('/api/register', formData)
                .then(response => {
                    alert(response.data.message);
                    context.commit('setName', response.data.data.name);
                    context.commit('setApiKey', response.data.data.token);
                    localStorage.setItem('user_id', response.data.data.id);
                    localStorage.setItem('cart_id', response.data.data.cart_id);
                    window.location.href = "/home";
                })
                .catch(error => {
                    reject(error);
                })
        })
    },
    logout(context) {
        axios.get('api/logout')
            .then((response) => {
                context.commit('removeName');
                context.commit('removeApiKey');
                alert(response.data.message);
                window.location.href = "/auth";
            })
    },
    addApiKey(context, key) {
        context.commit('setApiKey', key);
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};

