<template>
    <div class="col-12">
        <div class="card single-product-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="card-side-img">
                        ><a class="product-thumbnail d-block" :href="'/product/' + this.id">
                        <img :src="this.image_path" alt="">
                        <!-- Badge--><span class="badge bg-primary">Sale</span></a>
                    </div>
                    <div class="card-content px-4 py-2">
                        <a class="product-title d-block text-truncate mt-0" :href="'/product/' + this.id">{{this.name}}</a>
                        <!-- Product Price-->
                        <p class="sale-price">{{this.price}} ₽</p>
                        <a class="btn btn-outline-info btn-sm" :href="'/product/' + this.id">
                        <svg class="bi bi-cart me-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                        </svg>Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Product.vue",
    props: ['id', 'name', 'description', 'weight', 'price', 'orders_count', 'category_id', 'image_path'],
}
</script>

<style scoped>
    a {
        cursor: pointer !important;
    }
</style>
