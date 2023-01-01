@extends('admin.layouts.app')

@section('content')
    @include('components.flash')

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
                                <i class="fa fa-user"></i>
                                عنوان صفحه
                            </h3>
                        </div>
                    </div>

                </div>
            </div>

            <div class="m-portlet__head-tools">
                <a href="<?= route('person.create') ?>" class="btn btn-info m-btn m-btn--custom m-btn--icon portlet-action-button">
                    <span><i class="la la-plus"></i><span>افزودن محصول جدید</span></span>
                </a>
            </div>

        </div>
        <div class="m-portlet__body">

            <!--begin::Section-->
            <div class="m-section">

                <div class="m-section__content">

                    @include('admin.person._filter')

                    <div class="table-responsive">
                        <table class="table m-table table-bordered table-hover text-center big-header">
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th></th>
                                <th>نام</th>
                                <th>نامک</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($people as $person)
                                <tr>
                                    <td>{{ $person->id }}</td>
                                    <td><img src="{{ $person->cover('mini') }}" class="img-circle" width="50" height="50" alt=""></td>
                                    <td><a href="{{ $person->viewLink() }}">{{ $person->name }}</a></td>
                                    <td class="foreign">{{ $person->slug }}</td>
                                    <td class="m-datatable__cell">
                                        <a href="{{ route('person.edit', $person) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="ویرایش ">
                                            <i class="la la-edit"></i>
                                        </a>


                                        <form class="form-inline" method="POST" action="{{ route('person.destroy', $person) }}" data-confirm-delete>
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="حذف">
                                                <i class="la la-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan='9' class='table-no-record-found'>هیچ رکوردی یافت نشد</td></tr>
                            @endforelse
                            </tbody>
                        </table>

                        <div class="clearfix"></div>

                        {!! $people->appends($_GET)->render() !!}

                    </div>
                </div>
            </div>

            <!--end::Section-->
        </div>

        <!--end::Form-->
    </div>
@endsection
