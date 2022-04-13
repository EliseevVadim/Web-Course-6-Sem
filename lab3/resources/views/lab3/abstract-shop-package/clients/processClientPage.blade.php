@extends('lab3.abstract-shop-package.layouts.app')

@section('title')
    {{isset($client) ? "Редактировать информацию о клиенте" : "Добавить клиента"}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        {{isset($client) ? "Редактировать информацию о клиенте" : "Добавить клиента"}}
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
                        <form enctype="multipart/form-data" action="{{!isset($client) ? "/addClient" : "/updateClient"}}" method="post">
                            @csrf
                            @if(isset($client))
                                <input type="hidden" name="id" value="{{$client->id}}" >
                                {{ @method_field('PUT') }}
                            @endif
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите ФИО клиента<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="text" name="client_full_name" required placeholder="ФИО..." value="{{isset($client) ? $client->client_full_name : null}}">
                            </div>
                            <div class="form-group">
                                <label for="discipline-field" class="col-form-label text-light">Введите ИНН клиента<sup>*</sup>:</label>
                                <input class="form-control" id="discipline-field" name="INN" type="text" required placeholder="ИНН..." value="{{isset($client) ? $client->INN : null}}">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите адрес клиента<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="text" name="address" required placeholder="Адрес..." value="{{isset($client) ? $client->address : null}}">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите email клиента:</label>
                                <input class="form-control" id="group-field" type="email" name="email" placeholder="Email..." value="{{isset($client) ? $client->email : null}}">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите телефон клиента:</label>
                                <input class="form-control" id="group-field" type="text" name="phone" placeholder="Номер телефона..." value="{{isset($client) ? $client->phone : null}}">
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
