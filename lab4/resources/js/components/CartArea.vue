<template>
    <div class="container">
        <!-- Cart Wrapper -->
        <div class="cart-wrapper-area">
            <div class="cart-table card mb-3">
                <div class="table-responsive card-body">
                    <table class="table mb-0 text-center">
                        <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Description</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Remove</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in cartItems">
                            <th scope="row">
                                <img :src="item.product.image_path" alt="#">
                            </th>
                            <td>
                                <h6 class="mb-1">{{item.product.name}}</h6>
                                <span>{{item.product.price}} × {{item.quantity}}</span>
                            </td>
                            <td>
                                <span>{{item.quantity}}</span>
                            </td>
                            <td>
                                <a class="remove-product text-center" href="#" @click="removeOrder(item.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="20" height="20">
                                        <path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body border-top">
                    <div class="apply-coupon">
                        <h6 class="mb-0">Have a coupon?</h6>
                        <p class="mb-2">Enter your coupon code here &amp; get awesome discounts!</p>
                        <div class="coupon-form">
                            <form action="#">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control input-group-text text-start" type="text" placeholder="OFFER30">
                                        <button class="btn btn-primary" type="submit">Apply</button>
                                    </div>
                                </div>
                                <a class="btn btn-danger w-100 mt-4 " v-bind:class="{'disabled' : needToDisableCheckout}" @click="proceedToCheckout" href="/checkout" >{{ entireSum }} ₽ &amp; Перейти к оплате</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CartArea",
    mounted() {
        this.$store.dispatch('loadItems');
    },
    computed: {
        cartItems() {
            return this.$store.getters.ITEMS;
        },
        entireSum() {
            let sum = 0;
            for (let i = 0; i < this.cartItems.length; i++) {
                sum += parseFloat(this.cartItems[i].sum);
            }
            return sum;
        },
        needToDisableCheckout() {
            return this.entireSum === 0;
        }
    },
    methods: {
        removeOrder(id) {
            this.$store.dispatch('removeFromCart', id)
                .then(() => {
                    this.$store.dispatch('loadItems');
                })
        },
        proceedToCheckout() {
            localStorage.setItem('checkout_sum', this.entireSum.toString());
        }
    }
}
</script>

<style scoped>
    svg {
        position: relative;
        top: 50%;
        left: 36%;
        transform: translate(-50%,-50%);
        display: inline-block;
        width: 20px;
        height: 20px;
    }
</style>
