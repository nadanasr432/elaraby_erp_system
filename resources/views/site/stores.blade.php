@extends('site.layouts.app-main')
<style>
    table.table thead th {
        padding: 2px;
        color: #fff !important;
    }

    table.table tbody tr td {
        padding: 2px;
        color: #fff !important;
    }

    .form-control {
        height: 50px !important;
    }

</style>
@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background="{{ asset('assets/images/banner/banner01.jpg') }}"></div>
        <div class="container">
            <div class="banner-content">
                @if (session('error'))
                    <div class="alert alert-danger fade show">
                        {{ session('error') }}
                    </div>
                @endif

                <h1 class="text-center">
                    {{ __('main.create-new-company') }}
                </h1>
                @if (!$stores->isEmpty())
                    <h5 class="text-center" style="width: 80%; margin: 20px auto!important;">
                        {{ __('main.create-new-company') }}
                    </h5>
                    <table dir="rtl" class="text-center table table-bordered">
                        <thead>
                            <th>{{ __('stores.store-number') }}</th>
                            <th>{{ __('stores.store-name') }}</th>
                            <th>{{ __('stores.inside-a-branch') }}</th>
                        </thead>
                        <tbody>
                            @php $i=0; @endphp
                            @foreach ($stores as $store)
                                <tr>
                                    <td> {{ ++$i }} </td>
                                    <td> {{ $store->store_name }} </td>
                                    <td> {{ $store->branch->branch_name }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <h6 class="text-center mt-5" style="width: 80%; margin: 20px auto!important;">
                    {{ __('sidebar.add-new-store') }}
                </h6>
                <form action="{{ route('company.store.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ $_GET['company_id'] }}">

                    <div class="col-lg-4 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block"> {{ __('stores.store-name') }}
                                <span class="text-danger pull-left">*</span>
                            </label>
                            <input required type="text" class="form-control text-right" dir="rtl" name="store_name" />
                        </div>
                    </div>

                    <div class="col-lg-4 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block"> {{ __('stores.inside-a-branch') }}
                                <span class="text-danger pull-left">*</span>
                            </label>
                            <select required name="branch_id" class="form-control">
                                <option value="">{{ __('branches.branche-name') }}</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-xs-12 justify-content-center text-center mt-5">
                        <div class="form-group">
                            <button type="submit" style="color: #fff !important;"
                                class="col-lg-4  btn btn-md btn-outline-danger text-center" dir="rtl">
                                <i class="fa fa-check" style="color: #fff !important;"></i>
                                {{ __('main.save') }}
                            </button>
                            @if (!$stores->isEmpty())
                                <a role="button" href="{{ route('to.safes', $_GET['company_id']) }}"
                                    style="color: #fff !important;height: 50px;"
                                    class="btn btn-md btn-outline-info text-center" dir="rtl">
                                    {{ __('main.next') }}
                                    <i class="fa fa-long-arrow-left" style="color: #fff !important;"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
