<template>
    <form @submit.prevent="submit()">
        <div class="form-group">
            <div class="custom-file">
                <input type="file"
                       class="custom-file-input"
                       id="customFile"
                       @change="onAttachmentChange"
                >
                <label class="custom-file-label" for="customFile">{{ name }}</label>
            </div>
        </div>
        <div class="row d-flex justify-content-between">
            <div class="form-group w-50">
                <button type="submit" class="btn btn-primary" @click="submitSimply()">Загрузить</button>
            </div>
            <div class="form-group w-50">
                <button type="submit" class="btn btn-success" @click="submitWithGoogleDrive()">Загрузить с выгрузкой на Google Drive</button>
            </div>
        </div>
        <request-result-window ref="modal"></request-result-window>
    </form>
</template>

<script>
import UploadingResultWindow from "./RequestResultWindow";
export default {
    components: {UploadingResultWindow},
    data () {
        return {
            name: "Выберите файл...",
            attachment: null,
            useDrive : false,
        }
    },
    methods: {
        submit () {
            let uri = this.useDrive ? "/loadWithDrive" : '/';
            const config = { 'content-type': 'multipart/form-data' }
            const formData = new FormData()
            formData.append('name', this.name)
            formData.append('attachment', this.attachment)

            axios.post(uri, formData, config)
                .then(response => {
                    this.$refs.modal.setTitle("Успех!");
                    this.$refs.modal.setMessage("Файл успешно загружен");
                    this.clearAttachment();
                    this.$refs.modal.showWindow();
                    console.log(response.data['fileName']);
                })
                .catch(error => {
                    this.$refs.modal.setTitle("Ошибка!");
                    this.clearAttachment();
                    if (error.response.status === 422)
                        this.$refs.modal.setMessage(error.response.data.errors.attachment[0]);
                    else
                        this.$refs.modal.setMessage("Файл удалось загрузить, однако при обработке произошла ошибка. Попробуйте другой");
                    this.$refs.modal.showWindow();
                })

        },
        onAttachmentChange (e) {
            this.attachment = e.target.files[0]
            this.name = this.attachment.name
        },
        clearAttachment(){
            this.attachment = null;
            document.getElementById('customFile').value = null;
            this.name = "Выберите файл...";
        },
        submitWithGoogleDrive() {
            this.useDrive = true;
        },
        submitSimply() {
            this.useDrive = false;
        }
    }
}
</script>
