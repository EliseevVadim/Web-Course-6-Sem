@extends('layouts.app')

@section('title')
    Загруженные файлы
@endsection

@section('content')
    <h2 class="text-center">Файлы локального хранилища</h2>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Имя файла</th>
                        <th>Размер</th>
                        @canDeleteFromStorage
                        <th>Действия</th>
                        @endcanDeleteFromStorage
                    </tr>
                </thead>
                <tbody>
                    @foreach($storageFiles as $file)
                        <tr>
                            <td>{{$file->getFileName()}}</td>
                            <td>{{$file->getSize()}} bytes</td>
                            @canDeleteFromStorage
                            <td>
                                <delete-file-button v-bind:fileName="'{{$file->getFileName()}}'" v-bind:storageDeletion="true"></delete-file-button>
                            </td>
                            @endcanDeleteFromStorage
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <h2 class="text-center">Файлы из Google Drive</h2>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Имя файла</th>
                    <th>Размер</th>
                    @canDeleteFromStorage
                    <th>Действия</th>
                    @endcanDeleteFromStorage
                </tr>
                </thead>
                <tbody>
                @foreach($googleFiles as $file)
                    <tr>
                        <td>{{$file["name"]}}</td>
                        <td>{{$file["size"]}} bytes</td>
                        @canDeleteFromGoogleDrive
                        <td>
                            <delete-file-button v-bind:fileName="'{{$file["basename"]}}'" v-bind:storageDeletion="false"></delete-file-button>
                        </td>
                        @endcanDeleteFromGoogleDrive
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
