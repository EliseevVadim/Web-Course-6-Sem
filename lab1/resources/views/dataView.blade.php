@extends('layouts.app')

@section('title')
    Просмотр информации
@endsection

@section('content')
    <div id="app">
        <div class="container-fluid">
            <add-record-button></add-record-button>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Дата</th>
                        <th>Курс</th>
                        <th>Группа</th>
                        <th>Предмет</th>
                        <th>Лекции</th>
                        <th>Практические занятия</th>
                        <th>Лабораторные занятия</th>
                        <th>Модульный контроль</th>
                        <th>Консультации (семестр)</th>
                        <th>Консультации (экзамен)</th>
                        <th>Зачеты</th>
                        <th>Экзамены</th>
                        <th>Курсовые работы</th>
                        <th>ВКР бакалавов</th>
                        <th>ВКР специалистов</th>
                        <th>ВКР магистров</th>
                        <th>Руководство практикой</th>
                        <th>Госэкзамены</th>
                        <th>Рецензирование ВКР</th>
                        <th>Защита ВКР</th>
                        <th>Руководство аспирантами</th>
                        <th>Другое</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $record)
                        <tr>
                            <th scope="row">{{$record->id}}</th>
                            <td>{{$record->Date}}</td>
                            <td>{{$record->Course}}</td>
                            <td>{{$record->GroupName}}</td>
                            <td>{{$record->DisciplineName}}</td>
                            <td>{{$record->Lections}}</td>
                            <td>{{$record->Practics}}</td>
                            <td>{{$record->Labs}}</td>
                            <td>{{$record->Modules}}</td>
                            <td>{{$record->SemesterConsultations}}</td>
                            <td>{{$record->ExamConsultations}}</td>
                            <td>{{$record->Passes}}</td>
                            <td>{{$record->Exams}}</td>
                            <td>{{$record->Courseworks}}</td>
                            <td>{{$record->BachelorsFQW}}</td>
                            <td>{{$record->SpecialistsFQW}}</td>
                            <td>{{$record->MastersFQW}}</td>
                            <td>{{$record->PracticsManagement}}</td>
                            <td>{{$record->GrandExams}}</td>
                            <td>{{$record->FQWReviewing}}</td>
                            <td>{{$record->FQWPresenting}}</td>
                            <td>{{$record->AspirantsManagement}}</td>
                            <td>{{$record->Others}}</td>
                            <td>
                                <edit-record-button v-bind:activity-id="{{$record->id}}"></edit-record-button>
                                <delete-record-button v-bind:activity-id="{{$record->id}}"></delete-record-button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$data->links()}}
            </div>
        </div>
    </div>
@endsection
