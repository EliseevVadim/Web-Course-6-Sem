import Axios from "axios";

const state = {
    checkout: null
};

const getters = {
    CHECKOUT: state => {
        return state.checkout;
    }
};

const mutations = {
    setCheckout: (state, payload) => {
        state.checkout = payload;
    }
};

const actions = {
    createCheckout:  (context, formData) => {
        let sum = parseFloat(localStorage.getItem('checkout_sum'));
        let cartId = parseFloat(localStorage.getItem('cart_id'));
        formData.append('sum', sum);
        formData.append('cart_id', cartId);
        formData.append('checkout_state_id', 1);
        return new Promise((resolve, reject) => {
            axios.post('/api/checkouts', formData)
                .then((response) => {
                    alert("Заказ успешно оформлен.");
                    window.location.href = "/home";
                })
                .catch((error) => {
                    reject(error);
                })
        });

    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};
