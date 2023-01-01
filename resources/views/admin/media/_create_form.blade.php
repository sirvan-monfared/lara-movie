<div class="row">

    <div class="col-sm-12">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="path" name="path" class="form-control ltr" value="<?= old('path', "images/media/".date('Y')."/".date('m').'/') ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
            <label for="path">آدرس فایل</label>
            <p class="help-block"></p>
        </div>

        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="name" name="name" class="form-control ltr" value="<?= old('name') ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
            <label for="name">نام فایل </label>
            <p class="help-block"></p>
        </div>
    </div>

</div>
