<template>
    <form @submit.prevent="submit">
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
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Загрузить</button>
        </div>
        <uploading-result-window ref="modal"></uploading-result-window>
    </form>
</template>

<script>
import UploadingResultWindow from "./UploadingResultWindow";
export default {
    components: {UploadingResultWindow},
    data () {
        return {
            name: "Выберите файл...",
            attachment: null
        }
    },
    methods: {
        submit () {
            const config = { 'content-type': 'multipart/form-data' }
            const formData = new FormData()
            formData.append('name', this.name)
            formData.append('attachment', this.attachment)

            axios.post('/', formData, config)
                .then(response => {
                    this.$refs.modal.setTitle("Успех!");
                    this.$refs.modal.setMessage("Файл успешно загружен");
                    this.$refs.modal.showWindow();
                })
                .catch(error => {
                    this.$refs.modal.setTitle("Ошибка!");
                    console.log(error.response.data.errors.attachment[0]);
                    this.$refs.modal.setMessage(error.response.data.errors.attachment[0]);
                    this.$refs.modal.showWindow();
                })
        },
        onAttachmentChange (e) {
            this.attachment = e.target.files[0]
            this.name = this.attachment.name
        }
    }
}
</script>
