@extends('lab3.abstract-shop-package.layouts.app')

@section('title')
    Все поставщики
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Список поставщиков</h1>
        <a href="/openProviderAdding" class="btn btn-primary mb-3">Добавить</a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Название
                    <th>Страна</th>
                    <th>Город</th>
                    <th>Адрес</th>
                    <th>Почтовый индекс</th>
                    <th>Email</th>
                    <th>Номер телефона</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($providers as $provider)
                    <tr>
                        <td>{{$provider->id}}</td>
                        <td>{{$provider->provider_name}}</td>
                        <td>{{$provider->country}}</td>
                        <td>{{$provider->city}}</td>
                        <td>{{$provider->address}}</td>
                        <td>{{$provider->postal_code}}</td>
                        <td>{{$provider->email}}</td>
                        <td>{{$provider->phone}}</td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="deleteProvider({{$provider->id}})">Удалить</button>
                            <a href="/openProviderEditing/{{$provider->id}}" class="btn btn-warning">Редактировать</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function deleteProvider(id)
        {
            axios.delete('/deleteProvider/' + id)
                .then(() => {
                    location.reload();
                });
        }
    </script>
@endsection
