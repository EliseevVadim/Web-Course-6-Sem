<template>
    <div>
        <meta id="credentials" name="credentials" :content="content">
        <h1>Перенаправляем вас!</h1>
    </div>
</template>

<script>
export default {
    name: "SocialRedirecting",
    props: ['content'],
    mounted() {
        this.$store.dispatch('addApiKey', this.content.token);
        localStorage.setItem('user_id', this.content.id);
        localStorage.setItem('cart_id', this.content.cart_id);
        window.location.href = "/home";
    }
}
</script>

<style scoped>

</style>
