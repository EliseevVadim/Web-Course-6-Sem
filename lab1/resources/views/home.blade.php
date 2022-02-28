@extends('layouts.app')

@section('title')
    Домашняя страница
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Пользовательское меню</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row d-flex justify-content-center p-5">
                            <a class="btn btn-primary m-2" href="/data-view" role="button">Просмотр информации</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

