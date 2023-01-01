<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{ $page_name ?? 'عنوان صفحه' }}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="<?= route('admin') ?>" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i> پیشخوان
                    </a>
                </li>

                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="#" class="m-nav__link active-link">
                        <span class="m-nav__link-text">صفحه والد</span>
                    </a>
                </li>

                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a class="m-nav__link">
                        <span class="m-nav__link-text">{{ $page_name ?? 'عنوان صفحه' }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <button type="button" class="btn btn-accent m-btn m-btn--custom m-btn--icon portlet-action-button main-calendar">
            <span><i class="flaticon-calendar-with-a-clock-time-tools"></i><span>{{ shamsi()->now()->format('l j F Y') }}</span></span>
        </button>

    </div>
</div>

