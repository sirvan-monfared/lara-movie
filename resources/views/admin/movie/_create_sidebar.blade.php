<div class="m-portlet m-portlet--last portlet--fancy portlet--accent m-portlet--head-lg m-portlet--responsive-mobile" id="main-fields-wrapper" style="margin-top: 30px">
    <div class="m-portlet__body">
        <div class="m-portlet__body form-float-input p-0">

            <label class="m-checkbox">
                <input type="checkbox" name="update_with_imdb" value="on"> بروزرسانی اطلاعات از IMDB
                <span></span>
            </label>

        </div>
    </div>
</div>

<div class="m-portlet m-portlet--last portlet--fancy portlet--accent m-portlet--head-lg m-portlet--responsive-mobile" id="main-fields-wrapper" style="margin-top: 30px">
    <div class="m-portlet__body">
        <div class="m-portlet__body form-float-input p-0">

            <div class="form-group select-group--float form-group--float form-group--icon m-0">
                <label for="actors">ژانرها</label>
                <span class="input-icon-addon top-3"> <i class="fa fa-users"></i> </span>
                <select name="genre[]" id="genre" multiple="multiple" class="form-control select2 select2-multiple" dir="rtl">
                    @foreach($genres as $genre_id => $genre)
                        <option value="{{ $genre_id }}" {{ activeState($genre_id, $movie->genres->pluck('id')->toArray()) }}>{{ $genre }}</option>
                    @endforeach
                </select>
                <p class="help-block"></p>
            </div>

        </div>
    </div>
</div>

<div class="m-portlet m-portlet--last portlet--fancy portlet--accent m-portlet--head-lg m-portlet--responsive-mobile" id="main-fields-wrapper" style="margin-top: 30px">
    <div class="m-portlet__body">
        <div class="m-portlet__body form-float-input p-0">


            <div class="form-group select-group--float form-group--float form-group--icon m-0">
                <label for="director">کارگردان</label>
                <span class="input-icon-addon top-3"> <i class="fa fa-user"></i> </span>
                <select name="directors[]" id="director" multiple class="form-control" dir="rtl" data-remote-load-data data-remote-url="{{ route('api.search.person') }}">
                    @foreach($movie->directors->reverse() as $person)
                        <option value="{{ $person->id }}" selected>{{ $person->name }}</option>
                    @endforeach
                </select>
                <p class="help-block"></p>
            </div>

        </div>
    </div>
</div>

<div class="m-portlet m-portlet--last portlet--fancy portlet--accent m-portlet--head-lg m-portlet--responsive-mobile" id="main-fields-wrapper" style="margin-top: 30px">
    <div class="m-portlet__body">
        <div class="m-portlet__body form-float-input p-0">

            <div id="actors-part">

                <h4 class="title">بازیگران</h4>

                <div id="inputs-part">
                    @foreach($movie->actors->reverse() as $person)
                        <div class="actor-finder">
                            <div class="row">
                                <div class="col-sm-6 form-group--modern form-group--float form-group--icon form-group-static p-0">
                                    <label>نام</label>
                                    <input type="text" class="form-control find-actor m-wrap span12" value="{{ $person->name }}">
                                    <span class="input-icon-addon top-3"><img src="{{ $person->featured_image->mini_path }}"></span>
                                </div>
                                <div class="col-sm-6 form-group--modern form-group--float form-group-static p-0">
                                    <label>نقش</label>
                                    <input type="text" name="role_name[]" class="form-control m-wrap" value="{{ $person->pivot->role_name }}">
                                </div>
                            </div>

                            <i class="control-button remove-field fa fa-minus"></i>

                            <input type="hidden" name="actors[]" value="{{ $person->id }}">

                            <div class="result_set">

                            </div>
                        </div>
                    @endforeach
                </div>

                <i class="control-button add-field fa fa-plus"></i>
            </div>


            <div id="dynamic-field-template" style="display: none">
                <div class="actor-finder">

                    <div class="row">
                        <div class="col-sm-6 form-group--modern form-group--float form-group--icon form-group-static p-0">
                            <label>نام</label>
                            <input type="text" class="form-control find-actor m-wrap span12">
                            <span class="input-icon-addon top-3"> </span>
                        </div>
                        <div class="col-sm-6 form-group--modern form-group--float form-group-static p-0">
                            <label>نقش</label>
                            <input type="text" name="role_name[]" class="form-control m-wrap span12">
                        </div>
                    </div>

                    <i class="control-button remove-field fa fa-minus"></i>
                    <input type="hidden" name="actors[]">
                    <div class="result_set"></div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="m-portlet m-portlet--last portlet--fancy portlet--accent m-portlet--head-lg m-portlet--responsive-mobile" id="main-fields-wrapper" style="margin-top: 30px">
    <div class="m-portlet__body">

        <div class="image-picker-wrapper">
            <h5 class="title">تصویر شاخص</h5>
            <image-gallery namespace="featured" type="image" csrf="{{ csrf_token() }}" media="{{ $movie->featuredImageArray() }}"></image-gallery>
        </div>

    </div>
</div>

<div class="m-portlet m-portlet--last portlet--fancy portlet--accent m-portlet--head-lg m-portlet--responsive-mobile" id="main-fields-wrapper" style="margin-top: 30px">
    <div class="m-portlet__body">

        <div class="image-picker-wrapper">
            <h5 class="title">پوستر</h5>
            <image-gallery namespace="poster" type="image" csrf="{{ csrf_token() }}" media="{{ $movie->posterImageArray() }}"></image-gallery>
        </div>

    </div>
</div>

<div class="m-portlet m-portlet--last portlet--fancy portlet--accent m-portlet--head-lg m-portlet--responsive-mobile" id="main-fields-wrapper" style="margin-top: 30px">
    <div class="m-portlet__body">

        <div class="image-picker-wrapper">
            <h5 class="title">گالری تصاویر</h5>
            <image-gallery namespace="gallery" multiple csrf="{{ csrf_token() }}" media="{{ $movie->gallery }}"></image-gallery>
        </div>

    </div>
</div>





