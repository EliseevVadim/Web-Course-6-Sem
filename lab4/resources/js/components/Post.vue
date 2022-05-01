<template>
  <div>
      <div class="container">
          <div class="pt-3 d-block"></div>
          <div class="blog-details-post-thumbnail position-relative">
              <img class="w-100 rounded-lg" :src="'../' + post.image_path" alt="">
          </div>
      </div>
      <div class="blog-description py-3">
          <div class="container"><a class="badge bg-primary mb-2 d-inline-block" href="#">Новость</a>
              <h3 class="mb-3">{{ post.title }}</h3>
              <div class="d-flex align-items-center mb-4">
                  <a class="badge-avater" href="#">
                      <img class="img-circle" :src="'../img/icons/mark.png'" alt="">
                  </a>
                  <span class="ms-2">Администрация</span>
              </div>
              <p class="fz-14">{{ post.description }}</p>
          </div>
      </div>
  </div>
</template>

<script>
export default {
    name: "Post",
    props: ['id'],
    mounted() {
        this.$store.dispatch('loadPostById', this.id);
    },
    computed: {
        post() {
            return this.$store.getters.CHOSEN_POST;
        }
    },
}
</script>

<style scoped>

</style>
