@extends('admin.layouts.app')

@section('content')
    <div class="m-portlet m-portlet--mobile">

        <div class="m-portlet__head">

            <div class="m-portlet__head">
                <div class="m-portlet__head-progress">
                    <!-- here can place a progress bar-->
                </div>
                <div class="m-portlet__head-wrapper">

                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <i class="fa fa-cloud-download-alt"></i>
                                ابزارهای دریافت خروجی
                            </h3>
                        </div>
                    </div>

                </div>
            </div>

            <div class="m-portlet__head-tools">

            </div>

        </div>


        <div class="m-portlet__body">

            <!--begin::Section-->
            <div class="m-section">

                <div class="m-section__content">

                    @include('admin.export._filter')

                </div>
            </div>

            <!--end::Section-->
        </div>

    </div>
@endsection
