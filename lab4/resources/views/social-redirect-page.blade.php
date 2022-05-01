@extends('layouts.app')

@section('content')
    <div id="app">
        <social-redirecting v-bind:content="{{$socialUserObject}}"></social-redirecting>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- PWA -->
    <script src="{{asset('js/pwa.js')}}"></script>
@endsection


