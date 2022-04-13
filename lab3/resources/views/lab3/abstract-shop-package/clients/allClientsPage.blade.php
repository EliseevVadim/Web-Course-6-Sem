@extends('lab3.abstract-shop-package.layouts.app')

@section('title')
    Все клиенты
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Список клиентов</h1>
        <a href="/openClientAdding" class="btn btn-primary mb-3">Добавить</a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ФИО</th>
                        <th>ИНН</th>
                        <th>Адрес</th>
                        <th>Email</th>
                        <th>Номер телефона</th>
                        <th>Число заказов</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{$client->client_full_name}}</td>
                            <td>{{$client->INN}}</td>
                            <td>{{$client->address}}</td>
                            <td>{{$client->email}}</td>
                            <td>{{$client->phone}}</td>
                            <td>{{$client->orders_count}}</td>
                            <td>
                                <button type="button" class="btn btn-danger" onclick="deleteClient({{$client->id}})">Удалить</button>
                                <a href="/openClientEditing/{{$client->id}}" class="btn btn-warning">Редактировать</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function deleteClient(id)
        {
            axios.delete('/deleteClient/' + id)
                .then(() => {
                    location.reload();
                });
        }
    </script>
@endsection
