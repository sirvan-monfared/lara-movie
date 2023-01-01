<div class="row">

    <div class="col-sm-12">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="name" name="name" class="form-control" value="<?= old('name', $person->name) ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
            <label for="name">نام و نام خانوادگی</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="slug" name="slug" class="form-control" value="<?= old('slug', $person->slug) ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
            <label for="slug">نامک</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="birth" name="birth" class="form-control" value="<?= old('birth', $person->birth) ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-calendar"></i> </span>
            <label for="birth">سال تولد</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="nationality" name="nationality" class="form-control" value="<?= old('nationality', $person->nationality) ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-clock"></i> </span>
            <label for="nationality">ملیت</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <textarea name="bio" id="bio" class="form-control medium"><?= old('bio', $person->bio) ?></textarea>
            <span class="input-icon-addon top-3"> <i class="fa fa-comment"></i> </span>
            <label for="bio">بیوگرافی</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <textarea name="description" id="description" class="form-control medium"><?= old('description', $person->description) ?></textarea>
            <span class="input-icon-addon top-3"> <i class="fa fa-comment"></i> </span>
            <label for="description">سایر توضیحات</label>
            <p class="help-block"></p>
        </div>
    </div>
</div>
