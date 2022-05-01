@extends('layouts.app')

@section('title')
    Страница регистрации
@endsection

@section('content')
    <div id="app">
        <register-area></register-area>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- All JavaScript Files -->
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/slideToggle.min.js')}}"></script>
    <script src="{{asset('js/internet-status.js')}}"></script>
    <script src="{{asset('js/tiny-slider.js')}}"></script>
    <script src="{{asset('js/baguetteBox.min.js')}}"></script>
    <script src="{{asset('js/countdown.js')}}"></script>
    <script src="{{asset('js/rangeslider.min.js')}}"></script>
    <script src="{{asset('js/vanilla-dataTables.min.js')}}"></script>
    <script src="{{asset('js/index.js')}}"></script>
    <script src="{{asset('js/magic-grid.min.js')}}"></script>
    <script src="{{asset('js/dark-rtl.js')}}"></script>
    <!-- Password Strength -->
    <script src="{{asset('js/active.js')}}"></script>
    <script src="{{asset('js/pswmeter.js')}}"></script>
    <!-- PWA -->
    <script src="{{asset('js/pwa.js')}}"></script>
@endsection
