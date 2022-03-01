<template>
    <div>
        <request-result-window ref="result"></request-result-window>
        <div id="confirmation-form" class="modal" tabindex="-1" role="dialog" v-if="visible">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Подтверждение действия</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeConfirmation()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Вы действительно хотите удалить файл <span v-model="fileName">{{fileName}} из {{this.isStorageDelete ? "локального хранилища" : "Google Drive"}}?</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="deleteFile()">Да</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeConfirmation()">Нет</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DeleteFileConfirmation",
    data() {
        return {
            visible : false,
            fileName : null,
            isStorageDelete : null
        }
    },
    methods : {
        openConfirmation(fileName, isStorageDelete) {
            this.fileName = fileName;
            this.isStorageDelete = isStorageDelete;
            this.visible = true;
        },
        closeConfirmation() {
            this.fileName = null;
            this.isStorageDelete = false;
            this.visible = false;
        },
        deleteFile() {
            let uri = this.isStorageDelete ? "deleteStorageFile/" : "deleteGoogleFile/";
            axios.delete(uri + this.fileName)
            .then(()=> {
                this.closeConfirmation();
                this.showResultWindow("Успех!", "Файл был удален");
                setTimeout(() => window.location.href = "/filesView", 2000);
                clearTimeout();
            })
            .catch((error)=> {
                this.closeConfirmation();
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
