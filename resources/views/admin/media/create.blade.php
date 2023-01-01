@extends('admin.layouts.form', [
    'page_name' => 'افزودن رسانه',
    'action' => route('admin.medias.store'),
    'method' => 'POST',
    'cancel' => route('admin.medias')
])

@section('form-fields')
    @include('admin.media._create_form')
@endsection

@section('form-sidebar')
    @include('admin.media._create_sidebar')
@endsection
