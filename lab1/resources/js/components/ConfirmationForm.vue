<template>
    <div>
        <request-result-window ref="result"></request-result-window>
        <div id="confirmation-form" class="modal" tabindex="-1" role="dialog" v-if="confirmationVisible">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Подтверждение действия</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Вы действительно хотите удалить запись № <span v-model="recordId">{{recordId}}</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="deleteRecord()">Да</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="close()">Нет</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ConfirmationForm",
    data() {
        return {
            confirmationVisible : false,
            recordId : 0
        }
    },
    methods : {
        open(id) {
            this.recordId = id;
            this.confirmationVisible = true;
        },
        close() {
            this.recordId = 0;
            this.confirmationVisible = false;
        },
        deleteRecord() {
            axios.delete('deleteRecord/' + this.recordId)
                .then(() => {
                    this.close();
                    this.showResultWindow("Успех!", "Запись была удалена");
                    setTimeout(() => window.location.href = "/data-view", 2000);
                    clearTimeout();
                })
                .catch((error) => {
                    this.showResultWindow("Ошибка!", error.response.data.message);
                })
        },
        showResultWindow(title, message) {
            this.$refs.result.setTitle(title);
            this.$refs.result.setMessage(message);
            this.$refs.result.showWindow();
        },
    }
}
</script>

<style>
    #confirmation-form {
        display: block;
        opacity: 1;
    }
</style>

