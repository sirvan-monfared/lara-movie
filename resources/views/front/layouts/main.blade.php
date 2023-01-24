<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="{{ asset('front/img/logo-icon.png') }}">
    <title>LaraMovie - open source movies database</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('front/vendor/slick/slick.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front/vendor/slick/slick-theme.min.css') }}" />

    <link href="{{ asset('front/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('front/css/osahan.min.css') }}" rel="stylesheet">

    @yield('styles')
</head>
<body id="page-top">

<div id="wrapper">

    @include('front.partials.menu')


    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">
            @include('front.partials.top_bar')


            <div class="container-fluid">
                @yield('content')
            </div>

        </div>


        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Laraplus {{ now()->year }} | Made with <i class="fas fa-heart fa-fw text-danger"></i> by <a target="_blank" href="https://laraplus.ir">Laraplus</a></span>
                </div>
            </div>
        </footer>

    </div>

</div>


<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/front.js') }}"></script>
<script src="{{ asset('front/vendor/jquery/jquery.min.js') }}" ></script>
<script src="{{ asset('front/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" ></script>
<script src="{{ asset('front/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('front/vendor/slick/slick.min.js') }}"></script>
<script src="{{ asset('front/js/osahan.min.js') }}"></script>
<script src="{{ asset('front/vendor/rocket-loader.min.js') }}"  data-cf-settings="ba4e3e7a948e537b5ccd24b1-|49" defer=""></script></body>

@yield('scripts')

@yield('javascript')
</html>
