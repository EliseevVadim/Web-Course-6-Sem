@extends('lab3.abstract-shop-package.layouts.app')

@section('title')
    {{isset($order) ? "Редактировать информацию о заказе" : "Добавить заказ"}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        {{isset($order) ? "Редактировать информацию о заказе" : "Добавить заказ"}}
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
                        <form enctype="multipart/form-data" action="{{!isset($order) ? "/addOrder" : "/updateOrder"}}" method="post">
                            @csrf
                            @if(isset($order))
                                <input type="hidden" name="id" value="{{$order->id}}" >
                                {{ @method_field('PUT') }}
                            @endif
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Выберите клиента<sup>*</sup>:</label>
                                <select class="form-control" id="group-field" name="client_id">
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}" {{(isset($order) && $order->client->id === $client->id) ? "selected" : ""}}>{{$client->id.'. '.$client->client_full_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Выберите товар<sup>*</sup>:</label>
                                <select class="form-control" id="group-field" name="product_id" onchange="updateSum()">
                                    @foreach($products as $product)
                                        <option price="{{$product->price}}" value="{{$product->id}}" {{(isset($order) && $order->product->id === $product->id) ? "selected" : ""}}>{{$product->product_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Введите количество единиц товара<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="number" name="quantity" required placeholder="Количество..." value="{{isset($order) ? $order->quantity : null}}" onchange="updateSum()">
                            </div>
                            <div class="form-group">
                                <label for="group-field" class="col-form-label text-light">Сумма заказа<sup>*</sup>:</label>
                                <input class="form-control" id="group-field" type="number" name="sum" required readonly placeholder="Сумма..." value="{{isset($order) ? $order->sum : null}}">
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
        function updateSum() {
            let outputField = document.getElementsByName('sum')[0];
            let quantity = document.getElementsByName('quantity')[0];
            let select = document.getElementsByName('product_id')[0];
            let price = select.options[select.selectedIndex].getAttribute('price');
            outputField.value = parseInt(quantity.value) * parseInt(price);
        }
    </script>
@endsection
