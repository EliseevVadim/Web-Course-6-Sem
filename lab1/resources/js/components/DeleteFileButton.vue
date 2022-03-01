<template>
    <div>
        <deletion-confirmation-form ref="confirm"></deletion-confirmation-form>
        <button class="btn btn-danger" @click="confirmDeleting()">Удалить файл</button>
    </div>
</template>

<script>
export default {
    name: "DeleteFileButton",
    props : ['filename', 'storagedeletion'],
    methods : {
        confirmDeleting() {
            console.log(this.filename);
            console.log(this.storagedeletion);
            this.$refs.confirm.openConfirmation(this.filename, this.storagedeletion);
        }
    }
}
</script>

<style scoped>

</style>
