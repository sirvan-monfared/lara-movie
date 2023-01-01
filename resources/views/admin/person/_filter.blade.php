<form method="GET" action="{{ route('person.index') }}"  class="m-form m-form--fit m--margin-bottom-20">

    <div class="row m--margin-bottom-20">
        <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile form-group form-group--float form-group--active">
            <input type="text" id="id" name="id" class="form-control" value="{{ request('id') }}">
            <label for="id">شناسه</label>
        </div>

        <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile form-group form-group--float form-group--active">
            <input type="text" id="name" name="name" class="form-control" value="{{ request('name') }}">
            <label for="name">نام </label>
        </div>

        <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile form-group form-group--float form-group--active">
            <input type="text" id="slug" name="slug" class="form-control" value="{{ request('slug') }}">
            <label for="customer_name">نامک</label>
        </div>
    </div>

    <div class="m-separator m-separator--dashed"></div>

    <div class="row text-right">
        <div class="col-lg-12">
            <a href="{{ route('person.index') }}" class="btn btn-secondary m-btn m-btn--icon">
                <span><i class="la la-close"></i><span>پاک سازی</span></span>
            </a>
            <button type="submit" class="btn btn-brand m-btn m-btn--icon">
                <span><i class="la la-search"></i><span>فیلتر</span></span>
            </button>
        </div>
    </div>

</form>
