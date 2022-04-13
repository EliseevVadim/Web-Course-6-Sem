@extends('lab3.abstract-shop-package.layouts.app')

@section('title')
    Все заказы
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Список заказов</h1>
        <a href="/openOrderAdding" class="btn btn-primary mb-3">Добавить</a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>id</th>
                    <th>ФИО клиента</th>
                    <th>Название товара</th>
                    <th>Количество единиц товара</th>
                    <th>Стоимость</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->client->client_full_name}}</td>
                        <td>{{$order->product->product_name}}</td>
                        <td>{{$order->quantity}}</td>
                        <td>{{$order->sum}}</td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="deleteOrder({{$order->id}})">Удалить</button>
                            <a href="/openOrderEditing/{{$order->id}}" class="btn btn-warning">Редактировать</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function deleteOrder(id)
        {
            axios.delete('/deleteOrder/' + id)
                .then(() => {
                    location.reload();
                });
        }
    </script>
@endsection
