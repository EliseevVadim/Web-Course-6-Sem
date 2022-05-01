<template>
    <div class="container">
        <div class="card product-details-card mb-3">
            <div class="card-body">
                <div class="product-gallery-wrapper">
                    <div class="product-gallery">
                        <a href="">
                            <img class="rounded" v-bind:src="'../' + this.product.image_path">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card product-details-card mb-3 direction-rtl">
            <div class="card-body">
                <h3>{{this.product.name}}</h3>
                <h1>{{this.product.price}} ₽</h1>
                <form @submit.prevent="addProductToCart">
                    <div class="input-group">
                        <input class="input-group-text form-control" type="number" value="1" id="quantity">
                        <button class="btn btn-primary w-50" type="submit">Добавить в коризну</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card product-details-card mb-3 direction-rtl">
            <div class="card-body">
                <h5>Description</h5>
                <p>{{this.product.description}}</p>
                <p>
                    <b>Вес: </b> <span>{{ this.product.weight }} г.</span>
                </p>
                <p>
                    <b>Заказов: </b> <span>{{ this.product.orders_count }}</span>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProductDetails",
    props: ['id'],
    data() {
        return {
            quantity: 1,
        }
    },
    mounted() {
        this.$store.dispatch('loadProductById', this.id);
    },
    computed: {
      product() {
          return this.$store.getters.CHOSEN;
      }
    },
    methods: {
        addProductToCart() {
            this.quantity = parseInt(document.getElementById('quantity').value);
            let formData = new FormData();
            let sum = parseFloat(this.quantity) * parseFloat(this.product.price);
            formData.append('product_id', this.product.id);
            formData.append('cart_id', localStorage.getItem('cart_id'));
            formData.append('quantity', this.quantity);
            formData.append('sum', sum.toString());
            this.$store.dispatch('addItemToCart', formData);
        }
    }
}
</script>

<style scoped>

</style>
