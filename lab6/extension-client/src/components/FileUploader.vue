<template>
  <div>
    <div class="container">
      <div class="row">
        <div class="col s12">
          <div class="row">
            <div class="file-field input-field">
              <div class="btn">
                <span>Выбрать файл</span>
                <input type="file" ref="files" @change="handleFilesChanging" class="invalid"/>
              </div>
              <div class="file-path-wrapper">
                <input class="file-path" v-bind:class="fileIsValid ? 'validate' : 'invalid'" type="text"
                       placeholder="Выберите файл" />
                <span class="helper-text" data-error="Файл должен быть не пустым и быть в формате .doc либо .docx"
                      data-success=""></span>
              </div>
            </div>
          </div>
          <button class="waves-effect waves-orange btn-large darken-1" id="check-button"
                  v-bind:class="fileIsValid ? '' : 'disabled'" @click="sendFileToCheck">Отправить на проверку</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FileUploader",
  data() {
    return {
      file: '',
      fileIsValid: false
    }
  },
  methods: {
    handleFilesChanging() {
      this.file = this.$refs.files.files[0];
      if (this.file === undefined || !(this.file.name.endsWith('.doc') || this.file.name.endsWith('.docx'))) {
        this.file = '';
        this.fileIsValid = false;
        return;
      }
      this.fileIsValid = true;
    },
    sendFileToCheck() {
      console.log(this.file);
      let formData = new FormData();
      formData.append('file', this.file);
      axios.post('http://localhost:3000/check-file', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(() => {
        console.log("succ");
      })
      .catch((error) => {
        console.log(error.response);
      })
    }
  }
}
</script>

<style scoped>
#check-button {
  background: #ea6767;
}
</style>
