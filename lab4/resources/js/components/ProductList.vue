<template>
    <div class="top-products-area product-list-wrap">
        <div class="container">
            <div class="row g-3">
                <product v-bind:description="product.description"
                         v-bind:id="product.id"
                         v-bind:name="product.name"
                         v-bind:weight="product.weight"
                         v-bind:price="product.price"
                         v-bind:orders_count="product.orders_count"
                         v-bind:category_id="product.category_id"
                         v-bind:image_path="product.image_path"
                         v-for="product in products"></product>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProductList.vue",
    mounted() {
        this.$store.dispatch('loadProducts');
    },
    computed: {
        products() {
            return this.$store.getters.PRODUCTS;
        }
    }
}
</script>

<style scoped>

</style>
