@extends('lab3.abstract-shop-package.layouts.app')

@section('title')
    Все категории товаров
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Список категорий товаров</h1>
        <a href="/openProductCategoryAdding" class="btn btn-primary mb-3">Добавить</a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Название</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->category_name}}</td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="deleteCategory({{$category->id}})">Удалить</button>
                            <a href="/openProductCategoryEditing/{{$category->id}}" class="btn btn-warning">Редактировать</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function deleteCategory(id)
        {
            axios.delete('/deleteProductCategory/' + id)
                .then(() => {
                    location.reload();
                });
        }
    </script>
@endsection
