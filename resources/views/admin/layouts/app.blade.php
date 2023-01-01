<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <title>لارا مووی | LaraMovie</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    @include('admin.layouts.partials._styles')
</head>
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    <div class="m-grid m-grid--hor m-grid--root m-page" id="app">

        @include('admin.layouts.partials._header')

        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

            @include('admin.layouts.partials._main_menu')

            <div class="m-grid__item m-grid__item--fluid m-wrapper">

                @include('admin.layouts.partials._sub_header')

                <div class="m-content">
                    @yield('content')
                </div>

            </div>
        </div>

        @include('admin.layouts.partials._footer')
    </div>

    @include('admin.layouts.partials._quick_navs')



    @include('admin.layouts.partials._scripts')
    @yield('scripts')

    @yield('javascript')
</body>
</html>
