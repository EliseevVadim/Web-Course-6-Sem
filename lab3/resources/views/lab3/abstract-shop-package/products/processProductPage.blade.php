@extends('lab3.abstract-shop-package.layouts.app')

@section('title')
    {{isset($product) ? "Редактировать информацию о товаре" : "Добавить товар"}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        {{isset($product) ? "Редактировать информацию о товаре" : "Добавить товар"}}
                    </div>
                    <div class="card-body bg-dark">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form enctype="multipart/form-data" action="{{!isset($product) ? "/addProduct" : "/updateProduct"}}" method="post">
                            @csrf
                            @if(isset($product))
                                <input type="hidden" name="id" value="{{$product->id}}" >
                                {{ @method_field('PUT') }}
                            @endif
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите название товара<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="text" name="product_name" required placeholder="Название..." value="{{isset($product) ? $product->product_name : null}}">
                            </div>
                            <div class="form-group">
                                <label for="discipline-field" class="col-form-label text-light">Введите описание товара<sup>*</sup>:</label>
                                <textarea class="form-control" id="discipline-field" name="description" type="text" required placeholder="Описание...">{{isset($product) ? $product->description : null}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите цену товара<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="number" name="price" required placeholder="Цена..." value="{{isset($product) ? $product->price : null}}">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Выберите картинку услуги
                                    @if(!isset($product))
                                        <sup>*</sup>
                                    @endif
                                    :</label>
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input"
                                           id="file"
                                           name="image_path"
                                           value=""
                                           {{isset($product) ? "" : "required"}}
                                    >
                                    <label class="custom-file-label" for="file"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Выберите категорию<sup>*</sup>:</label>
                                <select class="form-control" id="group-field" name="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{(isset($product) && $product->productCategory->id === $category->id) ? "selected" : ""}}>{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Выберите поставщика<sup>*</sup>:</label>
                                <select class="form-control" id="group-field" name="provider_id">
                                    @foreach($providers as $provider)
                                        <option value="{{$provider->id}}" {{(isset($product) && $product->provider->id === $provider->id) ? "selected" : ""}}>{{$provider->provider_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Выберите склад<sup>*</sup>:</label>
                                <select class="form-control" id="group-field" name="storage_id">
                                    @foreach($storages as $storage)
                                        <option value="{{$storage->id}}" {{(isset($product) && $product->productStorage->id === $product->id) ? "selected" : ""}}>{{$storage->storage_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-light">Поля, помеченные звездочкой <sup>*</sup>, обязательны для заполнения!</span>
                            <div class="row d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-primary w-25 mx-1">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".custom-file-input").on("change", function() {
            let fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
