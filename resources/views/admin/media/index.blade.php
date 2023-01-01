@extends('admin.layouts.app', [
    'page_name' => 'کتابخانه رسانه ها'
])

@section('content')
    <media-manager csrf="{{ csrf_token() }}"></media-manager>
@endsection
