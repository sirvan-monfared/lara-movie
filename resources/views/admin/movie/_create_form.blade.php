<div class="row">

    <div class="col-sm-12">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="title" name="title" class="form-control" value="<?= old('title', $movie->title) ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
            <label for="title">نام فیلم</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="slug" name="slug" class="form-control" value="<?= old('slug', $movie->slug) ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
            <label for="slug">نامک</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="year" name="year" class="form-control" value="<?= old('year', $movie->year) ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-calendar"></i> </span>
            <label for="year">سال ساخت</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="duration" name="duration" class="form-control" value="<?= old('duration', $movie->duration) ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-clock"></i> </span>
            <label for="duration">مدت زمان</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="language" name="language" class="form-control" value="<?= old('language', $movie->language) ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-language"></i> </span>
            <label for="name">زبان</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="base" name="base" class="form-control" value="<?= old('base', $movie->base) ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-flag"></i> </span>
            <label for="name">کشور سازنده</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="metas->imdb_id" name="metas->imdb_id" class="form-control" value="<?= old('metas->imdb_id', optional($movie->metas)['imdb_id']) ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
            <label for="metas->imdb_id">شناسه IMDB</label>
            <p class="help-block">
                @if ($movie && optional($movie)->imdbLink())
                    <a href="{{ $movie->imdbLink() }}" target="blank">مشاهده در پایگاه imdb</a>
                @endif
            </p>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <input type="text" id="metas->imdb_rating" name="metas->imdb_rating" class="form-control" value="<?= old('metas->imdb_rating', optional($movie->metas)['imdb_rating']) ?>">
            <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
            <label for="metas->imdb_rating">امتیاز IMDB</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <textarea name="plot" id="plot" class="form-control medium"><?= old('plot', $movie->plot) ?></textarea>
            <span class="input-icon-addon top-3"> <i class="fa fa-comment"></i> </span>
            <label for="plot">خلاصه داستان</label>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group form-group--float form-group--icon form-group--active">
            <textarea name="description" id="description" class="form-control medium"><?= old('description', $movie->description) ?></textarea>
            <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
            <label for="description">سایر توضیحات</label>
            <p class="help-block"></p>
        </div>
    </div>
</div>
