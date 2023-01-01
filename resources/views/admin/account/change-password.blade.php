@extends('admin.layouts.form', [
    'action' => route('account.password.update'),
    'method' => 'POST',
    'cancel' => route('admin')
])

@section('form-fields')
    <div class="form-group form-group--float form-group--icon form-group--active">
        <input type="password" id="old-password" name="old-password" class="form-control"
               value="<?= old('old-password') ?>">
        <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
        <label for="name">رمز عبور فعلی</label>
        <p class="help-block"></p>
    </div>

    <div class="form-group form-group--float form-group--icon form-group--active">
        <input type="password" id="password" name="password" class="form-control" value="<?= old('password') ?>">
        <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
        <label for="name">رمزعبور</label>
        <p class="help-block"></p>
    </div>

    <div class="form-group form-group--float form-group--icon form-group--active">
        <input type="password" id="password-confirm" name="password-confirm" class="form-control"
               value="<?= old('password-confirm') ?>">
        <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
        <label for="name">تکرار رمز عبور</label>
        <p class="help-block"></p>
    </div>
@endsection

@section('form-sidebar')

@endsection
