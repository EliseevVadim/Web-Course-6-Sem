import Axios from "axios";

const state = {
    products: null,
    chosenProduct: null
};

const getters = {
    PRODUCTS: state => {
        return state.products;
    },
    CHOSEN: state => {
        return state.chosenProduct;
    }
};

const mutations = {
    setProducts: (state, payload) => {
        state.products = payload;
    },
    setChosenProduct: (state, payload) => {
        state.chosenProduct = payload;
    }
};

const actions = {
    loadProducts: async (context, payload) => {
        await axios.get('/api/products')
            .then((response) => {
                context.commit('setProducts', response.data.data);
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
