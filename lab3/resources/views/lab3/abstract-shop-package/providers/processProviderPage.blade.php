@extends('lab3.abstract-shop-package.layouts.app')

@section('title')
    {{isset($provider) ? "Редактировать информацию о поставщике" : "Добавить поставщика"}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        {{isset($provider) ? "Редактировать информацию о поставщике" : "Добавить поставщика"}}
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
                        <form enctype="multipart/form-data" action="{{!isset($provider) ? "/addProvider" : "/updateProvider"}}" method="post">
                            @csrf
                            @if(isset($provider))
                                <input type="hidden" name="id" value="{{$provider->id}}" >
                                {{ @method_field('PUT') }}
                            @endif
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите название поставщика<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="text" name="provider_name" required placeholder="Название..." value="{{isset($provider) ? $provider->provider_name : null}}">
                            </div>
                            <div class="form-group">
                                <label for="discipline-field" class="col-form-label text-light">Введите страну поставщика<sup>*</sup>:</label>
                                <input class="form-control" id="discipline-field" name="country" type="text" required placeholder="Страна..." value="{{isset($provider) ? $provider->country : null}}">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите город поставщика<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="text" name="city" required placeholder="Город..." value="{{isset($provider) ? $provider->city : null}}">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите адрес поставщика<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="text" name="address" required placeholder="Адрес..." value="{{isset($provider) ? $provider->address : null}}">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите почтовый индекс поставщика<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="text" name="postal_code" required placeholder="Индекс..." value="{{isset($provider) ? $provider->postal_code : null}}">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите email поставщика<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="email" name="email" placeholder="Email..." required value="{{isset($provider) ? $provider->email : null}}">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите телефон поставщика:</label>
                                <input class="form-control" id="group-field" type="text" name="phone" placeholder="Номер телефона..." value="{{isset($provider) ? $provider->phone : null}}">
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
