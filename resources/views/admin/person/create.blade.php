@extends('admin.layouts.form', [
    'action' => route('person.store'),
    'method' => 'POST',
    'cancel' => route('person.index')
])

@section('form-fields')
    @include('admin.person._create_form')
@endsection

@section('form-sidebar')
    @include('admin.person._create_sidebar')
@endsection

@section('scripts')
    <script src="{{ asset('admin/scripts/remote-select.js') }}"></script>
@endsection

@section('javascript')
    <script>
        $('.select2-multiple').select2();
    </script>
@endsection
