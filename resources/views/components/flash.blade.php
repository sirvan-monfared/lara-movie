@if ($errors)
    @foreach($errors->all() as $error)
        <div class='m-alert m-alert--icon alert alert-danger' role='alert'>
            <div class='m-alert__icon'>
                <i class='la la-warning'></i>
            </div>
            <div class='m-alert__text'>
                {{ $error }}
            </div>
            <div class='m-alert__close'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'></button>
            </div>
        </div>
    @endforeach
@endif

@if (session()->has('flash'))
    <div class='m-alert m-alert--icon alert alert-success' role='alert'>
        <div class='m-alert__icon'>
            <i class='la la-check'></i>
        </div>
        <div class='m-alert__text'>
            {{ session('flash') }}
        </div>
        <div class='m-alert__close'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'></button>
        </div>
    </div>
@endif

@if (session()->has('flash-error'))
    <div class='m-alert m-alert--icon alert alert-danger' role='alert'>
        <div class='m-alert__icon'>
            <i class='la la-check'></i>
        </div>
        <div class='m-alert__text'>
            {{ session('flash-error') }}
        </div>
        <div class='m-alert__close'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'></button>
        </div>
    </div>
@endif

