<template>
    <div>
        <request-result-window ref="result"></request-result-window>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="visible">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title text-light" id="exampleModalLabel">{{ this.modelId === 0 ? "Добавление записи" : "Обновление записи" }}</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close" @click="closeForm()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="saveData">
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите название группы<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="text" required placeholder="Группа..." v-model = "model.group">
                            </div>
                            <div class="form-group">
                                <label for="discipline-field" class="col-form-label text-light">Введите название предмета<sup>*</sup>:</label>
                                <input class="form-control" id="discipline-field" type="text" required placeholder="Предмет..." v-model="model.discipline">
                            </div>
                            <div class="row d-flex">
                                <div class="row d-flex flex-column w-50">
                                    <div class="form-group">
                                        <label for="date-field" class="col-form-label text-light">Дата<sup>*</sup>:</label>
                                        <input type="date" class="form-control" id="date-field" required placeholder="Выберите дату" v-model="model.date">
                                    </div>
                                    <div class="form-group">
                                        <label for="course-field" class="col-form-label text-light">Введите курс<sup>*</sup>:</label>
                                        <input class="form-control" id="course-field" type="number" required placeholder="Курс..." v-model="model.course">
                                    </div>
                                    <div class="form-group">
                                        <label for="lections-field" class="col-form-label text-light">Часы лекций:</label>
                                        <input class="form-control" id="lections-field" type="number" placeholder="Лекции..." v-model="model.lections">
                                    </div>
                                    <div class="form-group">
                                        <label for="practics-field" class="col-form-label text-light">Часы практик:</label>
                                        <input class="form-control" id="practics-field" type="number" placeholder="Практики..." v-model="model.practics">
                                    </div>
                                    <div class="form-group">
                                        <label for="labs-field" class="col-form-label text-light">Часы лабораторных:</label>
                                        <input class="form-control" id="labs-field" type="number" placeholder="Лабораторные..." v-model="model.labs">
                                    </div>
                                    <div class="form-group">
                                        <label for="modules-field" class="col-form-label text-light">Модульные контроли:</label>
                                        <input class="form-control" id="modules-field" type="number" placeholder="Модули..." v-model="model.modules">
                                    </div>
                                    <div class="form-group">
                                        <label for="semesterConsultations-field" class="col-form-label text-light">Семестровые консультации:</label>
                                        <input class="form-control" id="semesterConsultations-field" type="number" placeholder="Сем. конс...." v-model="model.semesterConsultations">
                                    </div>
                                    <div class="form-group">
                                        <label for="examConsultations-field" class="col-form-label text-light">Экзаменационные консультации:</label>
                                        <input class="form-control" id="examConsultations-field" type="number" placeholder="Экз. конс...." v-model="model.examConsultations">
                                    </div>
                                    <div class="form-group">
                                        <label for="passes-field" class="col-form-label text-light">Зачеты:</label>
                                        <input class="form-control" id="passes-field" type="number" placeholder="Зачеты..." v-model="model.passes">
                                    </div>
                                    <div class="form-group">
                                        <label for="exams-field" class="col-form-label text-light">Эказмены:</label>
                                        <input class="form-control" id="exams-field" type="number" placeholder="Эказмены..." v-model="model.exams">
                                    </div>
                                </div>
                                <div class="row d-flex flex-column w-50">
                                    <div class="form-group">
                                        <label for="courseworks-field" class="col-form-label text-light">Курсовые работы:</label>
                                        <input class="form-control" id="courseworks-field" type="number" placeholder="Курсовые..." v-model="model.courseworks">
                                    </div>
                                    <div class="form-group">
                                        <label for="bachelorsFQW-field" class="col-form-label text-light">ВКР бакалавов:</label>
                                        <input class="form-control" id="bachelorsFQW-field" type="number" placeholder="ВКР бакалавов..." v-model="model.bachelorsFQW">
                                    </div>
                                    <div class="form-group">
                                        <label for="specialistsFQW-field" class="col-form-label text-light">ВКР специалистов:</label>
                                        <input class="form-control" id="specialistsFQW-field" type="number" placeholder="ВКР специалистов..." v-model="model.specialistsFQW">
                                    </div>
                                    <div class="form-group">
                                        <label for="mastersFQW-field" class="col-form-label text-light">ВКР магистров:</label>
                                        <input class="form-control" id="mastersFQW-field" type="number" placeholder="ВКР магистров..." v-model="model.mastersFQW">
                                    </div>
                                    <div class="form-group">
                                        <label for="practicsManagement-field" class="col-form-label text-light">Руководство практикой:</label>
                                        <input class="form-control" id="practicsManagement-field" type="number" placeholder="Практика..." v-model="model.practicsManagement">
                                    </div>
                                    <div class="form-group">
                                        <label for="grandExams-field" class="col-form-label text-light">Госэкзамены:</label>
                                        <input class="form-control" id="grandExams-field" type="number" placeholder="Госэкзамены..." v-model="model.grandExams">
                                    </div>
                                    <div class="form-group">
                                        <label for="FQWReviewing-field" class="col-form-label text-light">Рецензирование ВКР:</label>
                                        <input class="form-control" id="FQWReviewing-field" type="number" placeholder="Рецензирование ВКР..." v-model="model.FQWReviewing">
                                    </div>
                                    <div class="form-group">
                                        <label for="FQWPresenting-field" class="col-form-label text-light">Защита ВКР:</label>
                                        <input class="form-control" id="FQWPresenting-field" type="number" placeholder="Защита ВКР..." v-model="model.FQWPresenting">
                                    </div>
                                    <div class="form-group">
                                        <label for="aspirantsManagement-field" class="col-form-label text-light">Руководство аспирантами:</label>
                                        <input class="form-control" id="aspirantsManagement-field" type="number" placeholder="Аспиранты..." v-model="model.aspirantsManagement">
                                    </div>
                                    <div class="form-group">
                                        <label for="others-field" class="col-form-label text-light">Другое:</label>
                                        <input class="form-control" id="others-field" type="number" placeholder="Другое..." v-model="model.others">
                                    </div>
                                </div>
                            </div>
                            <span class="text-light">Поля, помеченные звездочкой <sup>*</sup>, обязательны для заполнения!</span>
                            <div class="row d-flex justify-content-end mt-2">
                                <button type="button" class="btn btn-secondary w-25 mx-1" data-dismiss="modal" @click="closeForm()">Закрыть</button>
                                <button type="submit" class="btn btn-primary w-25 mx-1">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "DataProcessingWindow",
    data() {
        return {
            visible: false,
            modelId : 0,
            model: {
                'date' : null,
                'course' : null,
                'group' : null,
                'discipline' : null,
                'lections' : null,
                'practics' : null,
                'labs' : null,
                'modules' : null,
                'semesterConsultations' : null,
                'examConsultations' : null,
                'passes' : null,
                'exams' : null,
                'courseworks' : null,
                'bachelorsFQW' : null,
                'specialistsFQW' : null,
                'mastersFQW' : null,
                'practicsManagement' : null,
                'grandExams' : null,
                'FQWReviewing' : null,
                'FQWPresenting' : null,
                'aspirantsManagement' : null,
                'others' : null
            }
        }
    },
    methods: {
        openEditingForm(modelId) {
            this.modelId = modelId;
            if (modelId !== 0) {
                axios.get('activity', {
                    params: {
                        id : this.modelId
                    }
                })
                .then(response => {
                  this.model = response.data;
                  this.visible = true;
                })
                .catch(error => {
                    console.log(error);
                })
            }
        },
        openAddingForm() {
            this.visible = true;
        },
        closeForm() {
            this.visible = false;
            this.modelId = 0;
            this.model = {
                'date' : null,
                'course' : null,
                'group' : null,
                'discipline' : null,
                'lections' : null,
                'practics' : null,
                'labs' : null,
                'modules' : null,
                'semesterConsultations' : null,
                'examConsultations' : null,
                'passes' : null,
                'exams' : null,
                'courseworks' : null,
                'bachelorsFQW' : null,
                'specialistsFQW' : null,
                'mastersFQW' : null,
                'practicsManagement' : null,
                'grandExams' : null,
                'FQWReviewing' : null,
                'FQWPresenting' : null,
                'aspirantsManagement' : null,
                'others' : null
            };
        },
        saveData() {
            const config = { 'content-type': 'application/json', 'accept' : 'application/json' };
            const formData = new FormData();
            formData.append('date', this.model.date);
            formData.append('course', this.model.course);
            formData.append('group', this.model.group);
            formData.append('discipline', this.model.discipline);
            formData.append('lections', this.model.lections);
            formData.append('practics', this.model.practics);
            formData.append('labs', this.model.labs);
            formData.append('modules', this.model.modules);
            formData.append('semesterConsultations', this.model.semesterConsultations);
            formData.append('examConsultations', this.model.examConsultations);
            formData.append('passes', this.model.passes);
            formData.append('exams', this.model.exams);
            formData.append('courseworks', this.model.courseworks);
            formData.append('bachelorsFQW', this.model.bachelorsFQW);
            formData.append('specialistsFQW', this.model.specialistsFQW);
            formData.append('mastersFQW', this.model.mastersFQW);
            formData.append('practicsManagement', this.model.practicsManagement);
            formData.append('grandExams', this.model.grandExams);
            formData.append('FQWReviewing', this.model.FQWReviewing);
            formData.append('FQWPresenting', this.model.FQWPresenting);
            formData.append('aspirantsManagement', this.model.aspirantsManagement);
            formData.append('others', this.model.others);
            if (this.modelId === 0) {
                axios.post('/addRecord', formData, config)
                    .then(() => {
                        this.closeForm();
                        this.showResultWindow("Успех!", "Запись успешно добавлена");
                        this.updateView();
                    })
                    .catch(() => {
                        this.showResultWindow("Ошибка!", "Необходимо заполнить все обязательные поля.");
                    })
            }
            else {
                formData.append('id', this.modelId);
                axios.post('/updateRecord', formData, config)
                    .then(() => {
                        this.closeForm();
                        this.showResultWindow("Успех!", "Запись успешно обновлена");
                        this.updateView();
                    })
                    .catch((error) => {
                        this.showResultWindow("Ошибка!", error.response.data.message);
                    })
            }
        },
        showResultWindow(title, message) {
            this.$refs.result.setTitle(title);
            this.$refs.result.setMessage(message);
            this.$refs.result.showWindow();
        },
        updateView() {
            setTimeout(() => window.location.href = "/data-view", 2000);
            clearTimeout();
        }
    }
}
</script>

<style>
    #exampleModal {
        opacity: 1;
        display: block;
        position: fixed;
        top: 2%;
        left: 0;
        z-index: 1000;
        overflow-y: scroll;
    }
    #exampleModal::-webkit-scrollbar {
        width: 0;
    }
</style>
