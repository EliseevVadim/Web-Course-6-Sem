import Axios from "axios";

const state = {
    userOrders: null,
};

const getters = {
    ORDERS: state => {
        return state.userOrders;
    }
};

const mutations = {

};

const actions = {
    addItemToCart(context, payload) {
        axios.post('/api/orders', payload)
            .then(() => {
                alert("Заказ был успешно сделан. Для дальнейших действий перейдите во вкадку \"Корзина\".");
                window.location.href = "/home";
            })
            .catch((error) => {
                console.log(error.response);
            })
    },
    removeFromCart(context, id) {
        axios.delete('/api/orders/' + id)
            .then(() => {
                alert("Заказ был удален");
            })
            .catch((error) => {
                console.log(error.response.data);
            })
    }
};


export default {
    state,
    getters,
    mutations,
    actions,
};
