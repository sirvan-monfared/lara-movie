<form method="POST" action="{{ route('export.download') }}"  class="m-form m-form--fit m--margin-bottom-20">
    @csrf

    <div class="row m--margin-bottom-20">

        <div class="form-group select-group--float form-group--float col-lg-3">
            <label for="data_type">نوع اطلاعات خروجی</label>
            <select name="data_type" id="data_type" class="form-control simple-select">
                <option value="email">ایمیل</option>
                <option value="phone">تلفن</option>
            </select>
            <p class="help-block"></p>
        </div>

        <div class="form-group select-group--float form-group--float col-lg-3">
            <label for="file_type">نوع فایل خروجی</label>
            <select name="file_type" id="file_type" class="form-control simple-select">
                <option value="txt">فایل متنی text</option>
                <option value="csv">فایل اکسل </option>
            </select>
            <p class="help-block"></p>
        </div>

        <product-selector :inline="true" :domain="{{ new App\Models\Domain(['product_id' => request('product_id'), 'version_id' => request('version_id')]) }}"></product-selector>

        <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile form-group select-group--float form-group--float">
            <label for="is_active">وضعیت دامنه</label>
            <select name="is_active" id="is_active" class="form-control simple-select">
                <option value="all">همه</option>
                <option value="1" {{ (request('is_active') == 1) ? 'selected' : null }}>فعال</option>
                <option value="0" {{ (is_numeric(request('is_active')) && request('is_active') == 0) ? 'selected' : null }}>غیرفعال</option>
            </select>
            <p class="help-block"></p>
        </div>

    </div>

    <div class="m-separator m-separator--dashed"></div>

    <div class="row text-right">
        <div class="col-lg-12">
            <button type="submit" class="btn btn-brand m-btn m-btn--icon">
                <span><i class="fa fa-cloud-download-alt"></i><span>دریافت خروجی</span></span>
            </button>
        </div>
    </div>

</form>
