<template>
    <div>
        <!-- Internet Connection Status -->
        <!-- # This code for showing internet connection status -->
        <div class="internet-connection-status" id="internetStatus"></div>
        <div class="login-wrapper d-flex align-items-center justify-content-center">
            <div class="custom-container">
                <div class="text-center px-4"><img class="login-intro-img" :src="'img/bg-img/pizza-bg.png'" alt=""></div>
                <!-- Register Form -->
                <div class="register-form mt-4">
                    <h6 class="mb-3 text-center">Авторизуйтесь для дальнейшей работы с PizzGram</h6>
                    <div class="alert-danger mb-3 px-2 text-center" v-if="needToDisplayError">
                        <b>{{this.error}}</b>
                    </div>
                    <form @submit.prevent="authorize">
                        <div class="form-group">
                            <input class="form-control" type="email" placeholder="Email" v-model="email" @focus="needToDisplayError = false">
                        </div>
                        <div class="form-group position-relative">
                            <input class="form-control" id="psw-input" type="password" placeholder="Enter Password" v-model="password"  @focus="needToDisplayError = false">
                            <div class="position-absolute" id="password-visibility"><i class="bi bi-eye"></i><i class="bi bi-eye-slash"></i></div>
                        </div>
                        <button class="btn btn-primary w-100" type="submit">Войти</button>
                    </form>
                </div>
                <!-- Login Meta -->
                <div class="login-meta-data text-center">
                    <p class="mt-3">Войти через социальные сети:</p>
                    <div class="d-flex justify-content-between mb-3">
                        <a href="/social-auth/vkontakte">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="32" height="32">
                                <path d="M31.4907 63.4907C0 94.9813 0 145.671 0 247.04V264.96C0 366.329 0 417.019 31.4907 448.509C62.9813 480 113.671 480 215.04 480H232.96C334.329 480 385.019 480 416.509 448.509C448 417.019 448 366.329 448 264.96V247.04C448 145.671 448 94.9813 416.509 63.4907C385.019 32 334.329 32 232.96 32H215.04C113.671 32 62.9813 32 31.4907 63.4907ZM75.6 168.267H126.747C128.427 253.76 166.133 289.973 196 297.44V168.267H244.16V242C273.653 238.827 304.64 205.227 315.093 168.267H363.253C359.313 187.435 351.46 205.583 340.186 221.579C328.913 237.574 314.461 251.071 297.733 261.227C316.41 270.499 332.907 283.63 346.132 299.751C359.357 315.873 369.01 334.618 374.453 354.747H321.44C316.555 337.262 306.614 321.61 292.865 309.754C279.117 297.899 262.173 290.368 244.16 288.107V354.747H238.373C136.267 354.747 78.0267 284.747 75.6 168.267Z"/>
                            </svg>
                        </a>
                        <a href="/social-auth/telegram">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" width="32" height="32">
                                <path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z"/>
                            </svg>
                        </a>
                        <a href="/social-auth/discord">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="32" height="32">
                                <path d="M524.531,69.836a1.5,1.5,0,0,0-.764-.7A485.065,485.065,0,0,0,404.081,32.03a1.816,1.816,0,0,0-1.923.91,337.461,337.461,0,0,0-14.9,30.6,447.848,447.848,0,0,0-134.426,0,309.541,309.541,0,0,0-15.135-30.6,1.89,1.89,0,0,0-1.924-.91A483.689,483.689,0,0,0,116.085,69.137a1.712,1.712,0,0,0-.788.676C39.068,183.651,18.186,294.69,28.43,404.354a2.016,2.016,0,0,0,.765,1.375A487.666,487.666,0,0,0,176.02,479.918a1.9,1.9,0,0,0,2.063-.676A348.2,348.2,0,0,0,208.12,430.4a1.86,1.86,0,0,0-1.019-2.588,321.173,321.173,0,0,1-45.868-21.853,1.885,1.885,0,0,1-.185-3.126c3.082-2.309,6.166-4.711,9.109-7.137a1.819,1.819,0,0,1,1.9-.256c96.229,43.917,200.41,43.917,295.5,0a1.812,1.812,0,0,1,1.924.233c2.944,2.426,6.027,4.851,9.132,7.16a1.884,1.884,0,0,1-.162,3.126,301.407,301.407,0,0,1-45.89,21.83,1.875,1.875,0,0,0-1,2.611,391.055,391.055,0,0,0,30.014,48.815,1.864,1.864,0,0,0,2.063.7A486.048,486.048,0,0,0,610.7,405.729a1.882,1.882,0,0,0,.765-1.352C623.729,277.594,590.933,167.465,524.531,69.836ZM222.491,337.58c-28.972,0-52.844-26.587-52.844-59.239S193.056,219.1,222.491,219.1c29.665,0,53.306,26.82,52.843,59.239C275.334,310.993,251.924,337.58,222.491,337.58Zm195.38,0c-28.971,0-52.843-26.587-52.843-59.239S388.437,219.1,417.871,219.1c29.667,0,53.307,26.82,52.844,59.239C470.715,310.993,447.538,337.58,417.871,337.58Z"/>
                            </svg>
                        </a>
                    </div>
                    <p class="mb-0">Еще не зарегистрированы? <a class="stretched-link" href="/register">Зарегистрируйтесь!</a></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AuthorizationArea",
    data() {
        return {
            email: "",
            password: "",
            error: "Невозможно выполнить вход",
            needToDisplayError: false
        }
    },
    methods: {
        authorize() {
            this.$store.dispatch('login', {
                email: this.email,
                password: this.password
            })
            .catch((error) => {
                this.email = "";
                this.password = "";
                this.needToDisplayError = true;
            });
        }
    }
}
</script>

<style scoped>

</style>
