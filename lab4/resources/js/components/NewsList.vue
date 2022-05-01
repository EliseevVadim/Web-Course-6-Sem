<template>
    <div class="container">
        <div class="row g-3 justify-content-center">
            <div class="col-12" v-for="post in this.posts">
                <div class="card shadow-sm blog-list-card">
                    <div class="d-flex align-items-center">
                        <div class="card-blog-img position-relative" :style="{backgroundImage:`url(${post.image_path})`}"></div>
                        <div class="card-blog-content">
                            <span class="badge bg-danger rounded-pill mb-2 d-inline-block">{{ post.posting_time }}</span>
                            <a class="blog-title d-block mb-3 text-dark" :href="/post/ + post.id">{{post.title}}</a>
                            <a class="btn btn-primary btn-sm" :href="/post/ + post.id">Подробнее</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NewsList",
    mounted() {
        this.$store.dispatch('loadPosts');
    },
    computed: {
        posts() {
            return this.$store.getters.POSTS;
        }
    }
}
</script>

<style scoped>

</style>
