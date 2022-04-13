@extends('lab3.abstract-shop-package.layouts.app')

@section('title')
    Все товары
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Список товаров</h1>
        <a href="/openProductAdding" class="btn btn-primary mb-3">Добавить</a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Название
                    <th>Описание</th>
                    <th>Цена</th>
                    <th>Путь к изображению</th>
                    <th>Категория</th>
                    <th>Поставщик</th>
                    <th>Склад</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->description}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->image_path}}</td>
                        <td>{{$product->productCategory->category_name}}</td>
                        <td>{{$product->provider->provider_name}}</td>
                        <td>{{$product->productStorage->storage_name}}</td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="deleteProduct({{$product->id}})">Удалить</button>
                            <a href="/openProductEditing/{{$product->id}}" class="btn btn-warning">Редактировать</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function deleteProduct(id)
        {
            axios.delete('/deleteProduct/' + id)
                .then(() => {
                    location.reload();
                });
        }
    </script>
@endsection
