@extends('front.layouts.main', [
    'show_search' => false,
])

@section('content')
    <div id="app">
        <movies-list></movies-list>
    </div>
@endsection

