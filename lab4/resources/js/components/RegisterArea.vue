<template>
    <div>
        <!-- Preloader -->
        <div id="preloader">
            <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
        </div>
        <!-- Internet Connection Status -->
        <!-- # This code for showing internet connection status -->
        <div class="internet-connection-status" id="internetStatus"></div>
        <!-- Back Button -->
        <div class="login-back-button"><a href="/auth">
            <svg class="bi bi-arrow-left-short" width="32" height="32" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
            </svg></a></div>
        <div class="login-wrapper d-flex align-items-center justify-content-center">
            <div class="custom-container">
                <div class="text-center px-4">
                    <img class="login-intro-img" :src="'img/bg-img/pizza-bg.png'" alt="#"></div>
                <!-- Register Form -->
                <div class="register-form mt-4">
                    <h6 class="mb-3">Создайте аккаунт в PizzGram</h6>
                    <div class="alert-danger mb-3 px-2" v-if="needToDisplayErrors">
                        <li v-for="error in this.errors">
                            <b>{{error}}</b>
                        </li>
                    </div>
                    <form @submit.prevent="register">
                        <div class="form-group text-start mb-3">
                            <input class="form-control" type="text" placeholder="Email address" v-model="email" @focus="needToDisplayErrors = false">
                        </div>
                        <div class="form-group text-start mb-3">
                            <input class="form-control" type="text" placeholder="Username" v-model="name" @focus="needToDisplayErrors = false">
                        </div>
                        <div class="form-group text-start mb-3 position-relative">
                            <input class="form-control" id="psw-input" type="password" placeholder="New password" v-model="password" @focus="needToDisplayErrors = false">
                            <div class="position-absolute" id="password-visibility">
                                <i class="bi bi-eye"></i><i class="bi bi-eye-slash"></i>
                            </div>
                        </div>
                        <div class="form-group text-start mb-3 position-relative">
                            <input class="form-control" type="password" placeholder="Confirm password" v-model="confirm_password" @focus="needToDisplayErrors = false">
                        </div>
                        <div class="mb-3" id="pswmeter"></div>
                        <button class="btn btn-primary w-100" type="submit">Зарегистрироваться</button>
                    </form>
                </div>
                <!-- Login Meta -->
                <div class="login-meta-data text-center">
                    <p class="mt-3 mb-0">Уже зарегистрированы?<a class="stretched-link" href="/auth">Авторизуйтесь</a></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "RegisterArea",
    data() {
        return {
            email: "",
            name: "",
            password: "",
            confirm_password: "",
            errors: [],
            needToDisplayErrors: false
        }
    },
    methods: {
        register() {
            this.errors = [];
            this.$store.dispatch('register', {
                email: this.email,
                name: this.name,
                password: this.password,
                confirm_password: this.confirm_password
            })
            .catch(error => {
                this.email = "";
                this.name = "";
                this.password = "";
                this.confirm_password = "";
                let responseObject = error.response.data.data;
                for (let key in responseObject) {
                    if (responseObject.hasOwnProperty(key)) {
                        this.errors.push(responseObject[key][0]);
                    }
                }
                if (this.errors.length < 1)
                    this.errors.push("Ошибка регистрации. Попробуйте снова");
                this.needToDisplayErrors = true;
            })
        }
    }
}
</script>

<style lang="css" scoped>

</style>
