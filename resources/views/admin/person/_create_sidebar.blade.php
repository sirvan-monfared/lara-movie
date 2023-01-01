<div class="m-portlet m-portlet--last portlet--fancy portlet--accent m-portlet--head-lg m-portlet--responsive-mobile" id="main-fields-wrapper" style="margin-top: 30px">
    <div class="m-portlet__body">
        <div class="m-portlet__body form-float-input pr-0 pl-0">

            <div class="form-group select-group--float form-group--float form-group--icon">
                <label for="roles">نقش ها</label>
                <span class="input-icon-addon top-3"> <i class="fa fa-users"></i> </span>
                <select name="roles[]" id="roles" multiple="" class="form-control select2 select2-multiple" dir="rtl">
                        <option value="actor" {{ activeState('actor', $person->roles) }}>بازیگر</option>
                        <option value="director" {{ activeState('director', $person->roles) }}>کارگردان</option>
                        <option value="writer" {{ activeState('writer', $person->roles) }}>نویسنده</option>
                </select>
                <p class="help-block"></p>
            </div>

        </div>
    </div>
</div>

<div class="m-portlet m-portlet--last portlet--fancy portlet--accent m-portlet--head-lg m-portlet--responsive-mobile" id="main-fields-wrapper" style="margin-top: 30px">
    <div class="m-portlet__body">

        <div class="image-picker-wrapper">
            <h5 class="title">تصویر شاخص</h5>
            <image-gallery namespace="featured" type="image" csrf="{{ csrf_token() }}" media="{{ $person->featuredImageArray() }}"></image-gallery>
        </div>

    </div>
</div>

<div class="m-portlet m-portlet--last portlet--fancy portlet--accent m-portlet--head-lg m-portlet--responsive-mobile" id="main-fields-wrapper" style="margin-top: 30px">
    <div class="m-portlet__body">

        <div class="image-picker-wrapper">
            <h5 class="title">گالری تصاویر</h5>
            <image-gallery namespace="gallery" multiple csrf="{{ csrf_token() }}" media="{{ $person->gallery }}"></image-gallery>
        </div>

    </div>
</div>




