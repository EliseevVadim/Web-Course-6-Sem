import Axios from "axios";

const state = {
    items: null,
    chosenItem: null
};

const getters = {
    ITEMS: state => {
        return state.items;
    },
    CHOSEN_ITEM: state => {
        return state.chosenItem;
    }
};

const mutations = {
    setItems: (state, payload) => {
        state.items = payload;
    },
    setChosenItem: (state, payload) => {
        state.chosenItem = payload;
    }
};

const actions = {
    loadItems: async (context, payload) => {
        let cartId = localStorage.getItem('cart_id')
        await axios.get('/api/carts/' + cartId)
            .then((response) => {
                context.commit('setItems', response.data.data.orders);
            })
    },
    loadProductById: async (context, id) => {
        await axios.get('/api/products/' + id)
            .then((response) => {
                context.commit('setChosenProduct', response.data.data);
            })
            .catch((error) => {
                console.log(error.response);
            })
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};
