<template>
    <div>
        <button class="btn btn-primary" role="button" @click="displayForm()">Добавить запись</button>
        <data-processing-window ref="form"></data-processing-window>
    </div>
</template>

<script>
export default {
    name: "AddRecordButton",
    methods : {
        displayForm() {
            this.$refs.form.openAddingForm();
        }
    }
}
</script>

