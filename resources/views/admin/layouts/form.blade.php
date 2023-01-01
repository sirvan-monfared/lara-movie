@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">

            @include('components.flash')

            <form action="{{ $action }}" method="POST">
                @csrf
                @method($method)

                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" >
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-progress">
                            <!-- here can place a progress bar-->
                        </div>
                        <div class="m-portlet__head-wrapper">

                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        <i class="fa fa-user"></i>
                                        {{ $page_name ?? 'عنوان صفحه' }}
                                    </h3>
                                </div>
                            </div>

                            <div class="m-portlet__head-tools">
                                <a href="{{ $cancel }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                                    <i class="la la-arrow-right"></i>
                                    انصراف
                                </a>

                                <div class="btn-group">
                                    <button type="submit" name="submit_item" id="submit_item" class="btn btn-accent m-btn m-btn--icon m-btn--wide m-btn--md">
                                        <i class="la la-check"></i> ذخیره
                                    </button>
                                </div>

                                <!--  <?php //include 'includes/help_button.php' ?> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-lg-7">
                        <div class="m-portlet m-portlet--last portlet--fancy portlet--accent m-portlet--head-lg m-portlet--responsive-mobile" id="main-fields-wrapper" style="margin-top: 30px">
                            <div class="m-portlet__body">
                                <div class="m-portlet__body form-float-input pr-0 pl-0">

                                    @yield('form-fields')

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        @yield('form-sidebar')
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection


@section('javascript')
    <script>
        // initiateSelect2();
    </script>
@endsection
