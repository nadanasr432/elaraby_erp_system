@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder {
        height: 40px;
    }

    .bootstrap-select {
        width: 80% !important;
    }

    .form-control {
        height: 45px !important;
        padding: 10px !important;
    }

</style>
@section('content')

    <div class="row p-0">
        <div class="col-md-12">
            <div class="card">
                <!------HEADER----->
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold ml-1">
                            {{__('products.addnewproduct')}}
                        </h3>
                        <a class="btn btn-danger btn-sm pull-left p-1"
                           href="http://arabygithub.test/ar/client/journal/get">
                            {{__('products.back')}}
                        </a>
                    </div>
                </div>

                <!------HEADER----->
                <div class="card-body p-2">
                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                          action="{{ route('client.products.store', 'test') }}" enctype="multipart/form-data"
                          method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <div class="alert alert-danger" id="showErrMsg" style="display:none">

                        </div>

                        <div class="row p-0">
                            <!----store---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="store_id">

                                    {{__('products.store_name')}}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select required name="store_id" id="store" class="form-control">
                                    <option value="">{{__('products.choose_store')}}</option>
                                    <?php $i = 0; ?>
                                    @foreach ($stores as $store)
                                        @if ($stores->count() == 1)
                                            <option selected
                                                    value="{{ $store->id }}">{{ $store->store_name }}</option>
                                        @else
                                            @if ($i == 0)
                                                <option selected
                                                        value="{{ $store->id }}">{{ $store->store_name }}
                                                </option>
                                            @else
                                                <option
                                                    value="{{ $store->id }}">{{ $store->store_name }}</option>
                                            @endif
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </select>
                            </div>
                            <!---------------------->

                            <!----category_id---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="store_id">
                                    {{__('products.main_cat')}}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select required name="category_id" id="category" class="form-control">
                                    <option value="">{{__('products.choose_main_cat')}}</option>
                                    <?php $i = 0; ?>
                                    @foreach ($categories as $category)
                                        @if ($categories->count() == 1)
                                            <option type="{{ $category->category_type }}" selected
                                                    value="{{ $category->id }}">
                                                {{ $category->category_name }}
                                            </option>
                                        @else
                                            @if ($i == 0)
                                                <option type="{{ $category->category_type }}" selected
                                                        value="{{ $category->id }}">
                                                    {{ $category->category_name }}
                                                </option>
                                            @else
                                                <option type="{{ $category->category_type }}"
                                                        value="{{ $category->id }}">
                                                    {{ $category->category_name }}
                                                </option>
                                            @endif
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </select>
                            </div>
                            <!---------------------->

                            <!----sub_category---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="store_id">
                                    {{__('products.subcat')}}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select name="sub_category_id" id="sub_category" class="form-control">
                                    <option value="">{{__('products.choose_subcat')}}</option>
                                    @foreach ($sub_categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->sub_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-------------------->

                            <!----product_model---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>{{__('products.pmodel')}}</label>
                                <input type="text" name="product_model" placeholder="موديل المنتج" class="form-control"
                                       id='model'>
                            </div>
                            <!---------------------->

                            <!----product_name---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{__('products.pname')}}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="text" name="product_name" id="order_name"
                                       placeholder="{{__('products.pname')}}" class="form-control"
                                       required>
                            </div>
                            <!---------------------->

                            <!----unit_id---->
                            <div class="form-group col-lg-3 pr-0">
                                <label>
                                    {{__('products.punit')}}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select name="unit_id" class="form-control">
                                    <option value="">{{__('products.choseunit')}}</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!---------------------->

                            <!----code_universal---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{__('products.barcodenum')}}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="text" class="form-control" value="{{ $code_universal }}" dir="ltr"
                                       placeholder="{{__('products.barcodenum')}}"
                                       id="order_universal" name="code_universal"/>
                            </div>
                            <!---------------------->

                            <!----first_balance---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{__('products.storeqty')}}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="number" step="0.01" placeholder="{{__('products.storeqty')}}" name="first_balance"
                                       id="first_balance" value="0" class="form-control" required>
                            </div>
                            <!---------------------->

                            <!----purchasing_price--->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{__('products.costprice')}}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="number" step="0.01" name="purchasing_price" id='purchasing_price' value="0"
                                       class="form-control" placeholder="{{__('products.costprice')}}">
                            </div>
                            <!---------------------->

                            <!----wholesale_price--->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{__('products.wholeprice')}}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="number" step="0.01" name="wholesale_price" value="0" id="wholesale_price"
                                       class="form-control" placeholder="{{__('products.wholeprice')}}">
                            </div>
                            <!-------------------->

                            <!----sector_price--->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label>
                                    {{__('products.sectorprice')}}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="number" step="0.01" value="0" name="sector_price" placeholder="{{__('products.sectorprice')}}" id="sector_price"
                                       class="form-control">
                            </div>
                            <!-------------------->

                            <!----min_balance--->
                            <div class="form-group pull-right col-lg-3" dir="rtl">
                                <label>{{__('products.minimumqty')}}</label>
                                <input type="number" step="0.01" value="0" name="min_balance" id="min_balance"
                                       class="form-control"/>
                            </div>
                            <!-------------------->

                            <!-------color------->
                            <div class="form-group  col-lg-6 d-none" dir="rtl">
                                <label>{{__('products.choosecolor')}}</label>
                                <input style="width: 100%!important;" type="color" placeholder="{{__('products.choosecolor')}}" name="color"
                                       id="color"/>
                            </div>
                            <!---------------------->

                            <!----description---->
                            <div class="form-group col-lg-6" dir="rtl">
                                <label>{{__('products.pdesc')}}</label>
                                <textarea name="description" id="description" class="form-control" placeholder="{{__('products.pdesc2')}}" style="height: 60% !important;" rows="2"></textarea>
                            </div>
                            <!-------------------->

                            <div class="form-group col-lg-6 pull-right" dir="rtl">
                                <label>{{__('products.pimg')}}</label>
                                <input accept=".jpg,.png,.jpeg" type="file" name="product_pic"
                                       oninput="pic.src=window.URL.createObjectURL(this.files[0])" id="file"
                                       class="form-control">
                                <label class="d-block mt-2"> {{__('products.previewimg')}}</label>
                                <img id="pic" style="width: 100px; height:100px;"/>
                            </div>
                            <!---------------------->

                        </div>
                        <!--ROW END-->


                        <button class="btn btn-md btn-success w-100 font-weight-bold" type="submit">{{__('products.add')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        $("#selectForm2").submit(function (e) {
            e.preventDefault();

            var first_balance = $("#first_balance").val();
            var purchasing_price = $("#purchasing_price").val();
            var wholesale_price = $("#wholesale_price").val();
            var sector_price = $("#sector_price").val();
            var min_balance = $("#min_balance").val();


            if (isNaN(first_balance)) {
                $("#showErrMsg").text(" number only !! غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#first_balance").css("border-color", "red");
                $("#first_balance").val("");


                setTimeout(function () {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#first_balance").css("border-color", "#CACFE7");
            }


            if (isNaN(purchasing_price)) {
                $("#showErrMsg").text(" number only !!غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#purchasing_price").css("border-color", "red");
                $("#purchasing_price").val("");


                setTimeout(function () {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#purchasing_price").css("border-color", "#CACFE7");
            }

            if (isNaN(wholesale_price)) {
                $("#showErrMsg").text(" number only !!غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#wholesale_price").css("border-color", "red");
                $("#wholesale_price").val("");


                setTimeout(function () {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#wholesale_price").css("border-color", "#CACFE7");
            }

            if (isNaN(sector_price)) {
                $("#showErrMsg").text(" number only !! غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#sector_price").css("border-color", "red");
                $("#sector_price").val("");


                setTimeout(function () {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#sector_price").css("border-color", "#CACFE7");
            }

            if (isNaN(min_balance)) {
                $("#showErrMsg").text(" number only !! غير مسموح بالاحرف في هذا الحقل ارقام فقط!!");
                $("#showErrMsg").show("slow");
                $("#min_balance").css("border-color", "red");
                $("#min_balance").val("");


                setTimeout(function () {
                    $("#showErrMsg").hide("slow");
                }, 4000);

                return false;
            } else {
                $("#min_balance").css("border-color", "#CACFE7");
            }

            $(this).submit();

        });


        $('#category').on('change', function () {
            var category_name = $(this).val();
            var category_type = $(this).children("option:selected").attr('type');
            if (category_type == 'خدمية') {
                $('#first_balance').val("").attr('readonly', true);
                $('#model').val("").attr('readonly', true);
                // $('#order_universal').val("").attr('readonly', true);
                $('#min_balance').attr('readonly', true);
                $('#store').attr('disabled', true);
            } else {
                $('#first_balance').attr('readonly', false);
                $('#model').attr('readonly', false);
                $('#order_universal').attr('readonly', false);
                $('#min_balance').attr('readonly', false);
                $('#store').attr('disabled', false);
            }
        });
    </script>

@endsection
