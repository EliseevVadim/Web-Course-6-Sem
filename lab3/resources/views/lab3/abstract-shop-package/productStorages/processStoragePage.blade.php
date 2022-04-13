@extends('lab3.abstract-shop-package.layouts.app')

@section('title')
    {{isset($storage) ? "Редактировать информацию о складе" : "Добавить склад"}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        {{isset($storage) ? "Редактировать информацию о складе" : "Добавить склад"}}
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
                        <form enctype="multipart/form-data" action="{{!isset($storage) ? "/addProductStorage" : "/updateProductStorage"}}" method="post">
                            @csrf
                            @if(isset($storage))
                                <input type="hidden" name="id" value="{{$storage->id}}" >
                                {{ @method_field('PUT') }}
                            @endif
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите название склада<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="text" name="storage_name" required placeholder="Название..." value="{{isset($storage) ? $storage->storage_name : null}}">
                            </div>
                            <div class="form-group">
                                <label for="discipline-field" class="col-form-label text-light">Введите страну, в которой находится склад<sup>*</sup>:</label>
                                <input class="form-control" id="discipline-field" name="country" type="text" required placeholder="Страна..." value="{{isset($storage) ? $storage->country : null}}">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите город, в котором находится склад<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="text" name="city" required placeholder="Город..." value="{{isset($storage) ? $storage->city : null}}">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите адрес склада<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="text" name="storage_address" required placeholder="Адрес..." value="{{isset($storage) ? $storage->storage_address : null}}">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Выберите поставщика<sup>*</sup>:</label>
                                <select class="form-control" id="group-field" name="provider_id">
                                    @foreach($providers as $provider)
                                        <option value="{{$provider->id}}" {{(isset($storage) && $storage->provider->id === $provider->id) ? "selected" : ""}}>{{$provider->provider_name}}</option>
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
@endsection
