<template>
    <div class="card-body checkout-form">
        <h6 class="mb-3">Введите данные получателя</h6>
        <div class="alert-danger mb-3 px-2" v-if="needToDisplayErrors">
            <li v-for="error in this.errors">
                <b>{{error}}</b>
            </li>
        </div>
        <form @submit.prevent="createCheckout">
            <div class="form-group">
                <input class="form-control mb-3" type="text" placeholder="Введите полное имя..." v-model="model.client_full_name" @focus="needToDisplayErrors = false">
            </div>
            <div class="form-group">
                <input class="form-control mb-3" type="email" placeholder="Введите email..." v-model="model.client_email" @focus="needToDisplayErrors = false">
            </div>
            <div class="form-group">
                <input class="form-control mb-3" type="text" placeholder="Введите адрес..." v-model="model.client_address" @focus="needToDisplayErrors = false">
            </div>
            <button class="btn btn-danger mt-3 w-100" type="submit">Подтвердить заказ</button>
        </form>
    </div>
</template>

<script>
export default {
    name: "CheckoutForm",
    data() {
        return {
            model: {
                client_email: "",
                client_full_name: "",
                client_address: ""
            },
            needToDisplayErrors: false,
            errors: []
        }
    },
    methods: {
        createCheckout() {
            this.errors = [];
            let formData = new FormData();
            formData.append('client_full_name', this.model.client_full_name);
            formData.append('client_address', this.model.client_address);
            formData.append('client_email', this.model.client_email);
            this.$store.dispatch('createCheckout', formData)
                .catch((error) => {
                    this.model.client_email = "";
                    this.model.client_full_name = "";
                    this.model.client_address = "";
                    let responseObject = error.response.data.data;
                    console.log(responseObject);
                    for (let key in responseObject) {
                        if (responseObject.hasOwnProperty(key)) {
                            this.errors.push(responseObject[key][0]);
                        }
                    }
                    if (this.errors.length < 1)
                        this.errors.push("Ошибка заполнения формы. Попробуйте снова");
                    this.needToDisplayErrors = true;
                });
        }
    }
}
</script>

<style scoped>

</style>
