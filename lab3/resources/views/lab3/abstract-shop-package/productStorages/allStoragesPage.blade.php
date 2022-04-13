@extends('lab3.abstract-shop-package.layouts.app')

@section('title')
    Все склады
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Список складов</h1>
        <a href="/openProductStorageAdding" class="btn btn-primary mb-3">Добавить</a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Название
                    <th>Страна</th>
                    <th>Город</th>
                    <th>Адрес</th>
                    <th>Поставщик</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($storages as $storage)
                    <tr>
                        <td>{{$storage->id}}</td>
                        <td>{{$storage->storage_name}}</td>
                        <td>{{$storage->country}}</td>
                        <td>{{$storage->city}}</td>
                        <td>{{$storage->storage_address}}</td>
                        <td>{{$storage->provider->provider_name}}</td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="deleteStorage({{$storage->id}})">Удалить</button>
                            <a href="/openProductStorageEditing/{{$storage->id}}" class="btn btn-warning">Редактировать</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function deleteStorage(id)
        {
            axios.delete('/deleteProductStorage/' + id)
                .then(() => {
                    location.reload();
                });
        }
    </script>
@endsection
