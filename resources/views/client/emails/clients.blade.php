@extends('client.layouts.app-main')
<style>
    .bootstrap-select,
    select.form-control {
        width: 80% !important;
        /*display: inline !important;*/
    }

    label {
        display: block !important;
    }

    input[type='checkbox'] {
        margin-left: 20px;
        opacity: 1 !important;
        position: relative !important;
        pointer-events: auto !important;
        width: 20px;
        height: 20px;
    }

    img.img-thumb {
        width: 60px;
        height: 60px;
        border: 2px solid #eee;
        padding: 4px;
        margin: 5px auto;
        box-shadow: 1px 1px 5px #000;
    }

    table thead tr {
        background: #337ab7;
        color: #fff;
        font-size: 15px;
    }

    select {
        margin: 0px;
    }

    input[type=text],
    input[type=number],
    button,
    select {
        border-radius: 0 !important;
    }

</style>
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>الاخطاء :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12">
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('sidebar.send-mail-to-client') }}
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <br>
                    <form method="POST" action="{{ route('client.send.client.email') }}" id="myForm" dir="rtl"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="col-lg-6 no-print pull-right">
                            <div class="form-group" dir="rtl">
                                <label for="client_name"> {{ __('sales_bills.client-name') }} </label>
                                <select data-actions-box="true" multiple required
                                    class="selectpicker form-control show-tick selectpicker" data-live-search="true"
                                    title="{{ __('main.write-or-choose') }}" data-style="btn-info"
                                    name="outer_client_id[]" id="client_name">
                                    @foreach ($outer_clients as $outer_client)
                                        <option title="{{ $outer_client->client_name }}"
                                            value="{{ $outer_client->id }}">
                                            {{ $outer_client->client_name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.outer_clients.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="form-group" dir="rtl">
                                <label for="body"> {{ __('marketing.message') }} </label>
                                <textarea required name="body" class="form-control"
                                    style="width:100%;height:160px; resize:none;"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 no-print  pull-right">
                            <div class="form-group" dir="rtl">
                                <label for="subject"> {{ __('marketing.subject') }} </label>
                                <input required type="text" name="subject" style="padding:20px; height:60px;"
                                    class="form-control">
                            </div>
                            <div class="form-group" dir="rtl">
                                <label for="file"> {{ __('marketing.attach-files') }} </label>
                                <input type="file" class="form-control" name="files[]" multiple />
                            </div>
                            <div class="form-group" dir="rtl">
                                <label for="images" style="display:block ! important;">
                                    {{ __('marketing.choose-product-images') }} </label>
                                <a style="display:block !important;display:inline !important ; float:right !important; width:90%; height:auto !important; min-height: 70px; border:1px solid #dedede;
                                                                        padding:10px !important; text-align:center; font-size: 14px; font-weight:bold;"
                                    href="#mymoda21" data-toggle="modal" class="dismiss"><i
                                        class="fa fa-plus"></i><br />
                                    {{ __('marketing.click-to-select-products') }} </a>
                                <div class="clearfix"></div>
                                <div id="showChecked" class=" text-center text-danger"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" name="submit" class="no-print btn btn-success btn-md pull-right"><i
                                class="fa fa-envelope"></i> {{ __('marketing.send-message') }}
                        </button>
                        <div id="daily_details"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="mymoda21" class="modal" data-easein="bounceIn" dir="rtl" role="dialog"
        aria-labelledby="costumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header w-100">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center w-100">
                        <i class="fa fa-image"></i> عرض صورة المنتجات
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 images">
                            @if (!$products->isEmpty())
                                <table dir='rtl' class='table table-bordered table-hover table-condensed table-striped'
                                    style='text-align:center !important;'>
                                    <thead class='text-center'>
                                        <th class='text-center' style='width: 20%;'>
                                            <input type='checkbox' name='check_all' class='check_all' /> تحديد الكل
                                        </th>
                                        <th class='text-center'>اسم المنتج</th>
                                        <th class='text-center'>تفاصيل المنتج</th>
                                        <th class='text-center'> صورة المنتج</th>
                                    </thead>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td><input type='checkbox' form='myForm' name='check[]'
                                                    value='{{ asset($product->product_pic) }}' class='check' /></td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td><img src='{{ asset($product->product_pic) }}' class='img-thumb' /></td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnDismiss" data-dismiss="modal" class="btn btn-md btn-success"><i
                            class="fa fa-check"></i> تم وارفاق الصور
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        $(".check_all").click(function() {
            $('.check').not(this).prop('checked', this.checked);
        });
        $('#btnDismiss').on('click', function() {
            var numberOfChecked = $('input[name="check[]"]:checked').length;
            $('#showChecked').html("<br/>" + " تم اختيار وارفاق عدد ( " + numberOfChecked + " ) صورة منتج");
        });
    </script>
@endsection
