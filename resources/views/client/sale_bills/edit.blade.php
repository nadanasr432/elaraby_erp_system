@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder,
    .form-control {
        height: 40px !important;
    }

    a,
    a:hover {
        text-decoration: none;
        color: #444;
    }

    .bootstrap-select {
        width: 80% !important;
    }

    .bill_details {
        margin-top: 30px !important;
        min-height: 150px !important;
    }

    .btnsDiv {
        padding-top: 25px;
        height: auto !important;
        display: flex;
        justify-content: center;
    }

    td {
        padding: 5px !important;
    }
</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show text-center">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <div class="alert alert-success alert-dismissable text-center box_success d-none no-print">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        <span class="msg_success"></span>
    </div>

    <div class="alert alert-dark alert-dismissable text-center box_error d-none no-print">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        <span class="msg_error"></span>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-dark no-print">
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

    <form target="_blank" action="#" method="POST">
        @csrf
        @method('POST')
        <input type="hidden" value="{{ $saleBill->sale_bill_number }}" id="sale_bill_number"/>
        <h6 class="alert alert-info  text-center font-weight-bold no-print" dir="rtl">
            <center>
                {{ __('sales_bills.modify-customer-sales-invoice') }}
                <span class="badge badge-warning font-weight-bold text-dark">
                    رقم
                    {{$saleBill->company_counter}}
                </span>
            </center>
        </h6>

        <!-----store_id------->
        <div class="col-lg-4 pull-right">
            <label for=""> {{ __('sales_bills.choose-store') }} </label><br>
            <select name="store_id" id="store_id" class="selectpicker" data-style="btn-primary" data-live-search="true"
                    title="{{ __('sales_bills.choose-store') }}">
                @foreach ($stores as $store)
                    <option
                        value="{{ $store->id }}"
                        @if ($stores->count() == 1) selected @endif>
                        {{ $store->store_name }}
                    </option>
                @endforeach
            </select>
            <a target="_blank" href="{{ route('client.stores.create') }}" role="button"
               style="width: 15%;display: inline;" class="btn btn-sm btn-primary open_popup">
                <i class="fa fa-plus"></i>
            </a>
        </div>

        <!-----outer_client_id------->
        <div class="col-lg-4 pull-right no-print">
            <label for="" class="d-block">{{ __('sales_bills.client-name') }}</label>
            <select required name="outer_client_id" id="outer_client_id" class="selectpicker" data-style="btn-danger"
                    data-live-search="true" title="{{ __('sales_bills.client-name') }}" required>
                @foreach ($outer_clients as $outer_client)
                    <option
                        value="{{ $outer_client->id }}"
                        @if($outer_client->id == $saleBill->outer_client_id) selected @endif>
                        {{ $outer_client->client_name }}
                    </option>
                @endforeach
            </select>
            <a target="_blank" href="{{ route('client.outer_clients.create') }}" role="button"
               style="width: 15%;display: inline;" class="btn btn-sm btn-danger open_popup">
                <i class="fa fa-plus"></i>
            </a>
        </div>

        <!-----value_added_tax------->
        <div class="col-lg-4 pull-right">
            <div class="form-group" dir="rtl">
                <label for="value_added_tax"> {{ __('sales_bills.prices-for-tax') }} </label>
                <select required name="value_added_tax" id="value_added_tax" class="selectpicker w-100"
                        data-style="btn-info" data-live-search="true" required>
                    <option
                        @if($saleBill->value_added_tax == 0) selected @endif value="0">
                        {{ __('sales_bills.not-including-tax') }}
                    </option>
                    <option
                        @if ($saleBill->value_added_tax == 1) selected @endif value="1">
                        {{ __('sales_bills.including-tax') }}
                    </option>
                </select>
            </div>
        </div>

        <!-----date------->
        <div class="col-sm-4 pull-right no-print">
            <div class="form-group" dir="rtl">
                <label>{{ __('sales_bills.invoice-date') }}</label>
                <input
                    type="date" name="date" id="date"
                    class="form-control" required
                    value="{{ $saleBill->date }}"
                />
            </div>
        </div>

        <!-----time------->
        <div class="col-sm-4 pull-right no-print">
            <div class="form-group" dir="rtl">
                <label>{{ __('sales_bills.invoice-time') }}</label>
                <input
                    type="time" required name="time" id="time"
                    class="form-control" value="{{ $saleBill->time }}"
                />
            </div>
        </div>

        <!-----notes------->
        <div class="col-sm-4 pull-right no-print">
            <div class="form-group" dir="rtl">
                <label for="time">{{ __('main.notes') }}</label>
                <input
                    type="text" name="notes" class="form-control" id="notes"
                    value="{{ $saleBill->notes ?? '' }}"
                />
                <a data-toggle="modal" data-target="#myModal3"
                   class="btn btn-link add_extra_notes text-primary">
                    اضف ملاحظات اخرى
                </a>
            </div>
        </div>

        <div class="clearfix no-print"></div>

        <div class="outer_client_details no-print">
            <table class="table table-bordered table-striped table-condensed table-hover float-left">
                <thead>
                <th>{{ __('main.type') }}</th>
                <th>{{ __('main.indebtedness') }}</th>
                <th>{{ __('main.nationality') }}</th>
                <th>{{ __('main.tax-number') }}</th>
                <th>{{ __('main.phone') }}</th>
                <th>{{ __('main.address') }}</th>
                <th>{{ __('main.company') }}</th>
                </thead>
                <tbody>
                <tr>
                    <td id="category">{{ $saleBill->OuterClient->client_category }}</td>
                    <td id="balance_before">{{ $saleBill->OuterClient->prev_balance }}</td>
                    <td id="client_national">{{ $saleBill->OuterClient->client_national }}</td>
                    <td id="tax_number">{{ $saleBill->OuterClient->tax_number }}</td>
                    <td id="client_phone">{{ $saleBill->OuterClient->phones[0]->client_phone ?? '-' }}</td>
                    <td id="client_address">{{ $saleBill->OuterClient->addresses[0]->client_address ?? '-' }}</td>
                    <td id="shop_name">{{ $saleBill->OuterClient->shop_name }}</td>
                </tr>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>
        <hr class="no-print">
        <div class="options no-print mt-2">
            <div class="col-lg-3 pull-right">
                <label for=""> {{ __('sales_bills.product-code') }} </label>
                <select name="product_id" id="product_id" class="selectpicker" data-style="btn-success"
                        data-live-search="true" title="{{ __('sales_bills.product-code') }}">
                    @foreach ($all_products as $product)
                        <option
                            value="{{ $product->id }}"
                            data-tokens="{{ $product->code_universal }}">
                            {{ $product->product_name ?? ' '}}
                        </option>
                    @endforeach
                </select>
                <a target="_blank" href="{{ route('client.products.create') }}" role="button"
                   style="width: 15%;display: inline;" class="btn btn-sm btn-danger open_popup">
                    <i class="fa fa-plus"></i>
                </a>
                <div class="available text-center" style="color: #000; font-size: 14px; margin-top: 10px;"></div>
            </div>
            <!------PRICE------>
            <div class="col-lg-3 pull-right p-0">
                <label for="">{{ __('sales_bills.product-price') }}</label>
                <input style="margin-right:5px;margin-left:5px;" type="radio" name="price" id="sector"/>
                {{ __('main.retail') }}
                <input style="margin-right:5px;margin-left:5px;" type="radio" name="price" id="wholesale"/>
                {{ __('main.wholesale') }}
                <input type="number" name="product_price" value="0"
                       @cannot('تعديل السعر في فاتورة البيع') readonly @endcan
                       id="product_price" class="form-control"/>
            </div>

            <!------UNIT------>
            <div class="col-lg-4 pull-right">
                <label class="d-block" for=""> {{ __('main.quantity') }} </label>
                <input type="number" name="quantity" id="quantity"
                       style="width: 50%;"
                       class="form-control d-inline float-left"/>

                <select style="width: 50%;" class="form-control d-inline float-right" name="unit_id" id="unit_id">
                    <option value="">{{ __('units.unit-name') }}</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                    @endforeach
                </select>
            </div>

            <!------TOTAL------>
            <div class="col-lg-2 p-0 pull-right">
                <label for=""> {{ __('main.total') }} </label>
                <input type="number" name="quantity_price" readonly
                       id="quantity_price" class="form-control"/>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-lg-12 text-center">
            <button type="button" id="add" class="btn btn-info btn-md mt-3">
                <i class="fa fa-plus"></i>
                اضافة المنتج للفاتورة
            </button>
            <button type="button" id="edit" style="display: none" class="btn btn-success btn-md mt-3">
                <i class="fa fa-pencil"></i>
                تحديث بيانات المنتج
            </button>
        </div>
        <hr>
        </div>

        <!-----INV PRODUCTS------>
        <div class="col-lg-12 col-md-12 col-sm-12 bill_details">
            <h6 class="alert alert-info p-1 font-weight-bold text-center">
                <i class="fa fa-success-circle"></i>
                منتجات الفاتورة
            </h6>

            @php
                $elements = \App\Models\SaleBillElement::where('sale_bill_id', $saleBill->id)
                            ->where('company_id', $saleBill->company_id)
                            ->get();
                $extras = $saleBill->extras;
                $extra_settings = $company->extra_settings;
                $currency = $extra_settings->currency;
                $tax_value_added = $company->tax_value_added;
                $sum = [];
                $tbody = '';

                if (!$elements->isEmpty()) {
                    $i = 0;

                    foreach ($elements as $element) {

                        array_push($sum, $element->quantity_price);
                        $tbody .= '<tr>';
                        $tbody .= '<td>' . ++$i . '</td>';
                        $tbody .= '<td>' . ($element->product ? $element->product->product_name : ' ') . '</td>';
                        $tbody .= '<td>' . $element->product_price . '</td>';
                        if (!empty($element->unit_id))
                            $tbody .= '<td>' . $element->quantity . ' ' . $element->unit->unit_name . '</td>';
                        else
                            $tbody .= '<td>' . $element->quantity . '</td>';

                        $tbody .= '<td>' . $element->quantity_price . '</td>';
                        $tbody .= "
                            <td class='no-print' style='padding:5px;'>
                                <button type='button' sale_bill_number='" . $element->SaleBill->sale_bill_number . "' element_id='" .
                                    $element->id . "' class='btn btn-sm btn-info edit_element'>
                                    <i class='fa fa-edit'></i>
                                </button>
                                <button type='button' sale_bill_number='" . $element->SaleBill->sale_bill_number . "' element_id='" .
                                    $element->id . "' class='btn btn-sm btn-danger remove_element'>
                                    <i class='fa fa-trash'></i>
                                </button>

                                <form action='".route('client.sale_bills.return')."' style='display:none;' method='POST'>
                                    <input type='hidden' value='". $element->SaleBill->id ."' name='sale_bill_id' style='display:none;'>
                                    <input type='hidden' value='". $element->id ."' name='element_id' style='display:none;'>
                                    <input type='hidden' name='_token' value='".csrf_token()."' style='display:none;'>
                                    <button type='submit' class='btn btn-sm btn-warning remove_element' style='display:none;'>
                                        <i class='fa fa-refresh'></i> ارتجاع
                                    </button>
                                </form>
                                <form action='".route('client.sale_bills.return')."' style='display:inline;' method='POST'>
                                    <input type='hidden' value='". $element->SaleBill->id ."' name='sale_bill_id'>
                                    <input type='hidden' value='". $element->id ."' name='element_id'>
                                    <input type='hidden' name='_token' value='".csrf_token()."'>
                                    <button type='submit' class='btn btn-sm btn-warning remove_element'>
                                        <i class='fa fa-refresh'></i> ارتجاع
                                    </button>
                                </form>
                            </td>
                        </tr>";
                    }//end foreach

                } //end if condition
            @endphp

            <table class="table table-condensed table-striped table-bordered">
                <thead>
                <th> #</th>
                <th>اسم المنتج</th>
                <th>سعر الوحدة</th>
                <th>الكمية</th>
                <th>الاجمالى</th>
                <th class='no-print'>تحكم</th>
                </thead>
                <tbody>
                {!! $tbody !!}
                </tbody>
            </table>
            @php
                $total = array_sum($sum);
                $percentage = ($tax_value_added / 100) * $total;
                $after_total = $total + $percentage;
                $tax_option = $saleBill->value_added_tax;
                $saleBillDetails = '';
                if ($tax_option == 1) {
                    $total = $total * (100 / 115);
                    $total_with_option = $total;
                    $percentage = (15 / 100) * $total_with_option;
                    $after_total = $percentage + $total_with_option;
                }
                $previous_discount = \App\Models\SaleBillExtra::where('sale_bill_id', $saleBill->id)->where('action', 'discount')->first();
                if ($previous_discount->action_type == 'afterTax') {
                    $saleBillDetails .= " <div class='clearfix'></div> <div class='alert alert-dark alert-sm text-center'><div class='pull-right col-lg-6 '> اجمالى الفاتورة " . round($total, 2) .
                        ' ' . $currency . " </div> <div class='pull-left col-lg-6 '> اجمالى الفاتورة  بعد القيمة المضافة " . (round($after_total, 2) - (round($after_total, 2) / 100 * 5)) . ' ' . $currency . " <div class='clearfix'></div> </div>";
                } else {
                    $saleBillDetails .= " <div class='clearfix'></div> <div class='alert alert-dark alert-sm text-center'><div class='pull-right col-lg-6 '> اجمالى الفاتورة " . round($total, 2) .
                        ' ' . $currency . " </div> <div class='pull-left col-lg-6 '> اجمالى الفاتورة  بعد القيمة المضافة " . round($after_total, 2) . ' ' . $currency . " <div class='clearfix'></div> </div>";
                }
            @endphp
            {!! $saleBillDetails !!}
            <div class="clearfix"></div>
        </div>
        <!-----INV PRODUCTS------>


        <!--------////////////////////////////////////////////////////////////////////////////////////////-------->
        <!--------////////////////////////////////////////////////////////////////////////////////////////-------->
        <!--------////////////////////////////////////////////////////////////////////////////////////////-------->
        <!--------////////////////////////////////////////////////////////////////////////////////////////-------->
        <!--------////////////////////////////////////////////////////////////////////////////////////////-------->
        <!--------////////////////////////////////////////////////////////////////////////////////////////-------->


        <hr>
        <div class="col-lg-12 col-md-12 col-sm-12 after_totals">
            <?php
            $total = array_sum($sum);
            $previous_extra = \App\Models\SaleBillExtra::where('sale_bill_id', $saleBill->id)->where('action', 'extra')->first();
            if (!empty($previous_extra)) {
                $previous_extra_type = $previous_extra->action_type;
                $previous_extra_value = $previous_extra->value;
                if ($previous_extra_type == 'percent') {
                    $previous_extra_value = ($previous_extra_value / 100) * $total;
                }
                if (!empty($previous_extra_value) || $previous_extra_value != 0)
                    $after_discount = $total + $previous_extra_value;
                else {
                    $after_discount = $total;
                    $previous_extra_value = 0;
                }
            }

            if (!empty($previous_discount)) {
                $previous_discount_type = $previous_discount->action_type;
                $previous_discount_value = $previous_discount->value ? $previous_discount->value : 0;
                if ($previous_discount_type == 'percent') {
                    $previous_discount_value = ($previous_discount_value / 100) * $total;
                }
                $after_discount = $total - $previous_discount_value;
            }

            if (!empty($previous_extra) && !empty($previous_discount)) {
                $after_discount = $total - $previous_discount_value + $previous_extra_value;
            } else {
                $after_discount = $total;
            }

            if (isset($after_discount) && $after_discount != 0) {
                $percentage = ($tax_value_added / 100) * $after_discount;
                $after_total_all = $after_discount + $percentage;
            } else {
                $percentage = ($tax_value_added / 100) * $total;
                $after_total_all = $total + $percentage;
            }
            $tax_option = $saleBill->value_added_tax;

            if ($tax_option == 1) {
                $total_option = $total * (100 / 115);
                $total_with_option = $total_option;
                $percentage = (15 / 100) * $total_with_option;
                $after_total_all = $percentage + $total_with_option;
            }
            echo "
                <div class='clearfix'></div>
                    <div class='alert alert-secondary alert-sm text-center'>
                    اجمالى الفاتورة النهائى بعد الضريبة  : " . round($after_total_all, 2) . ' ' . $currency . "
                    </div>
                </div>";
            ?>
        </div>

        <div class="clearfix no-print"></div>
        <hr class="no-print">
        <div class="row no-print" style="margin: 20px auto;">
            <div class="col-lg-12">
                <div class="col-lg-6 col-md-6 col-xs-6 pull-right">
                    <div class="form-group" dir="rtl">
                        <label for="discount">{{ __('sales_bills.discount-on-the-total-bill') }}</label> <br>
                        <?php
                        foreach ($extras as $key) {
                            if ($key->action == 'discount') {
                                if ($key->action_type == 'pound') {
                                    $sale_bill_discount_value = $key->value;
                                    $sale_bill_discount_type = 'pound';
                                } else if ($key->action_type == 'percent') {
                                    $sale_bill_discount_value = $key->value;
                                    $sale_bill_discount_type = 'percent';
                                } else {
                                    $sale_bill_discount_value = $key->value;
                                    $sale_bill_discount_type = 'afterTax';
                                }
                            } else {
                                if ($key->action_type == 'pound') {
                                    $sale_bill_extra_value = $key->value;
                                    $sale_bill_extra_type = 'pound';
                                } else if ($key->action_type == 'percent') {
                                    $sale_bill_extra_value = $key->value;
                                    $sale_bill_extra_type = 'percent';
                                } else {
                                    $sale_bill_extra_value = $key->value;
                                    $sale_bill_extra_type = 'afterTax';
                                }
                            }
                        }
                        ?>
                        <select name="discount_type" id="discount_type" class="form-control"
                                style="width: 20%;display: inline;float: right; margin-left:5px;">
                            <option
                                @if (isset($sale_bill_discount_type) && $sale_bill_discount_type == 'pound') selected
                                @endif value="pound">
                                خصم قبل الضريبة (مسطح)
                            </option>
                            <option
                                @if (isset($sale_bill_discount_type) && $sale_bill_discount_type == 'percent') selected
                                @endif value="percent">
                                خصم قبل الضريبة (%)
                            </option>
                            <option
                                @if (isset($sale_bill_discount_type) && $sale_bill_discount_type == 'poundAfterTax' || $sale_bill_discount_type == 'afterTax') selected
                                @endif value="poundAfterTax">
                                ضمان اعمال (مسطح)
                            </option>
                            <option
                                @if (isset($sale_bill_discount_type) && $sale_bill_discount_type == 'poundAfterTaxPercent') selected
                                @endif value="poundAfterTaxPercent">
                                ضمان اعمال (نسبة)
                            </option>
                        </select>
                        <input type="text"
                               value="{{ isset($sale_bill_discount_value) ? $sale_bill_discount_value : 0 }}"
                               name="discount_value"
                               style="width: 50%;display: inline;float: right;" id="discount_value"
                               class="form-control "/>
                        <button type="button" class="btn btn-md btn-success pull-right text-center"
                                style="display: inline !important;width: 20% !important; height: 40px;margin-right: 20px; "
                                id="exec_discount">{{ __('main.apply') }}
                        </button>
                        <input type="text" id="discount_note" placeholder="ملاحظات الخصم. . ." class="form-control"
                               style="position:relative;top: 15px;width:93%; ">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6 pull-right">
                    <div class="form-group" dir="rtl">
                        <label for="extra">{{ __('main.shipping-expenses') }}</label> <br>
                        <select name="extra_type" id="extra_type" class="form-control"
                                style="width: 20%;display: inline;float: right;margin-left: 5px">
                            <option @if (isset($sale_bill_extra_type) && $sale_bill_extra_type == 'pound') selected
                                    @endif value="pound">
                                {{ $extra_settings->currency }}</option>
                            <option
                                @if (isset($sale_bill_extra_type) && $sale_bill_extra_type == 'percent') selected
                                @endif value="percent">%
                            </option>
                        </select>
                        <input value="{{ isset($sale_bill_extra_value) ? $sale_bill_extra_value :0 }}" type="text"
                               name="extra_value"
                               style="width: 50%;display: inline;float: right;" id="extra_value"
                               class="form-control"/>
                        <button type="button" class="btn btn-md btn-success pull-right text-center"
                                style="display: inline !important;width: 20% !important; height: 40px;margin-right: 20px; "
                                id="exec_extra">
                            تطبيق
                        </button>

                    </div>
                </div>
                <div class="clearfix"></div>
            </div> <!--  End Col-lg-12 -->
        </div>
        <!--  End Row -->
    </form>
    <hr>

    <!--------////////////////////////////////////////////////////////////////////////////////////////-------->
    <!--------////////////////////////////////////////////////////////////////////////////////////////-------->
    <!--------////////////////////////////////////////////////////////////////////////////////////////-------->
    <!--------////////////////////////////////////////////////////////////////////////////////////////-------->
    <!--------////////////////////////////////////////////////////////////////////////////////////////-------->
    <!--------////////////////////////////////////////////////////////////////////////////////////////-------->

    <div class="col-lg-12 no-print text-center btnsDiv">

        <form class="d-inline" method="POST"
              action="{{ route('client.sale_bills.cancel') }}">
            @csrf
            @method('POST')
            <input type="hidden" value="{{ $saleBill->sale_bill_number }}" name="sale_bill_number"/>
            <!------CANCEL BTN---->
            <button type="submit" class="btn btn-md close_btn btn-danger pull-right mr-1" style="height: 40px;">
                <i class="fa fa-trash"></i>
                {{ __('main.cancel') }}
            </button>
        </form>

        <button
            type="button" data-toggle="modal" style="height: 40px;"
            data-target="#myModal2" class="btn btn-md btn-dark pay_btn pull-right">
            <i class="fa fa-money"></i>
            {{ __('main.record') }}
        </button>
        <!------PRINT MAIN INVOICE---->
        <a class="btn btn-md btn-info text-white pull-right ml-1"
           href="{{route('client.sale_bills.print', $saleBill->token)}}" style="height: 40px;">
            حفظ و طباعة 1
        </a>

        <!------PRINT 1---->
        <a href="{{route('client.sale_bills.print', [$saleBill->token,2,1,0])}}"
           class="btn btn-md pull-right ml-1"
           style="height: 40px;border:1px solid #085d4a;background: #085d4a !important;color:white !important;">
            حفظ و طباعة 2
        </a>
        

        <!------PRINT 2---->
        <a href="{{route('client.sale_bills.print', [$saleBill->token,4,2,0])}}" 
          class="btn save_btn2 btn-md btn-primary pull-right ml-1" style="height: 40px;border:1px solid #5e8b0b;background: #5e8b0b !important;color:white !important;">
            حفظ و طباعة 3
        </a>
        <!------PRINT 2---->
        <a href="{{route('client.sale_bills.print', [$saleBill->token,2,3,0])}}" style="height: 40px;"
           class="btn btn-md btn-primary pull-right ml-1">
            حفظ و طباعة 4

        </a>

        <!------FATOORAH MOSWADA---->
        <a href="{{route('client.sale_bills.print', [$saleBill->token,2,1,1])}}" style="height: 40px;"
           class="btn btn-md btn-warning pull-right ml-1">
            فاتورة مسودة
        </a>

        <!------FATOORAH No Tax---->
        <a href="{{route('client.sale_bills.print', [$saleBill->token,3,2,0])}}" style="height: 40px;"
           class="btn btn-md btn-success pull-right ml-1">
            فاتورة غير ضريبية
        </a>

    </div>

    <div class="modal fade" dir="rtl" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header w-100">
                    <h4 class="modal-title text-center" id="myModalLabel2">دفع نقدى</h4>
                </div>
                <div class="modal-body">
                    @if ((isset($sale_bill_cash) && !$sale_bill_cash->isEmpty()) || (isset($sale_bill_bank_cash) && !$sale_bill_bank_cash->isEmpty()))
                        <table class="table table-condensed table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('main.amount') }}</th>
                                <th>{{ __('main.payment') }}</th>
                                <th>{{ __('main.delete') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $j = 0; $totalPaid = 0; ?>
                            @if (isset($sale_bill_cash) && !$sale_bill_cash->isEmpty())
                                @foreach ($sale_bill_cash as $cash)
                                    @php
                                        $totalPaid += $cash->amount;
                                    @endphp
                                    <tr>
                                        <td>{{ ++$j }}</td>
                                        <td>{{ $cash->amount }}</td>
                                        <td>
                                            دفع كاش نقدى
                                            ({{ $cash->safe->safe_name }})
                                        </td>
                                        <td>
                                            <button type="button" payment_method="cash" cash_id="{{ $cash->id }}"
                                                    class="btn btn-sm btn-danger delete_pay">{{ __('main.delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if (isset($sale_bill_bank_cash) && !$sale_bill_bank_cash->isEmpty())
                                @foreach ($sale_bill_bank_cash as $cash)
                                    <tr>
                                        <td>{{ ++$j }}</td>
                                        <td>{{ $cash->amount }}</td>
                                        <td>دفع بنكى شبكة
                                            <br>
                                            ({{ $cash->bank->bank_name }})
                                            <br>
                                            ( {{ $cash->bank_check_number }} )
                                        </td>
                                        <td>
                                            <button type="button" payment_method="bank" cash_id="{{ $cash->id }}"
                                                    class="btn btn-danger delete_pay">حذف
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    @endif
                    <input type="hidden" id="company_id" value="{{ $saleBill->company_id }}">
                    <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label> رقم العملية <span class="text-danger">*</span></label>
                            <input required readonly value="{{ $pre_cash }}" class="form-control" id="cash_number"
                                   type="text">
                        </div>
                        <div class="col-md-4">
                            <label> المبلغ المدفوع <span class="text-danger">*</span></label>
                            <input required class="form-control" id="amount" type="text" dir="ltr">
                        </div>
                        <div class="col-md-4">
                            <label> طريقة الدفع <span class="text-danger">*</span></label>
                            <select required id="payment_method" name="payment_method" class="form-control">
                                <option value="">اختر طريقة الدفع</option>
                                <option value="cash">دفع كاش نقدى</option>
                                <option value="bank">دفع بنكى شبكة</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 cash" style="display: none;">
                        <div class="col-md-4">
                            <label> خزنة الدفع <span class="text-danger">*</span></label>
                            <select style="width: 80% !important; display: inline !important;" required id="safe_id"
                                    class="form-control">
                                <option value="">اختر خزنة الدفع</option>
                                @foreach ($safes as $safe)
                                    <option value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                @endforeach
                            </select>
                            <a target="_blank" href="{{ route('client.safes.create') }}" role="button"
                               style="width: 15%;display: inline;" class="btn btn-sm btn-danger open_popup">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3 bank" style="display: none;">
                        <div class="col-md-4">
                            <label class="d-block"> البنك <span class="text-danger">*</span></label>
                            <select style="width: 80% !important; display: inline !important;" required id="bank_id"
                                    class="form-control">
                                <option value="">اختر البنك</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                @endforeach
                            </select>
                            <a target="_blank" href="{{ route('client.banks.create') }}" role="button"
                               style="width: 15%;display: inline;" class="btn btn-sm btn-danger open_popup">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <label for="">رقم المعاملة</label>
                            <input type="text" class="form-control" id="bank_check_number"/>
                        </div>
                        <div class="col-md-4">
                            <label for="">ملاحظات</label>
                            <input type="text" class="form-control" id="bank_notes"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-success pd-x-20 pay_cash" type="button">تسجيل الدفع</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="client_name" id="client_name"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>
                        اغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" dir="rtl" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header w-100">
                    <h4 class="modal-title w-100 text-center" id="myModalLabel3">
                        ملاحظات على الفاتورة
                    </h4>
                </div>
                <div class="modal-body">
                    <form id="myForm" action="{{route('save.notes')}}" method="post">
                        @csrf
                        @method('POST')

                        <input type="hidden" name="counter" value="{{$saleBill->company_counter}}"/>
                        <div class="notes">
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label class="d-block">
                                        الملاحظة رقم 1
                                    </label>
                                    <input
                                        @if(!empty($saleBill->sale_bill_notes[0]) && !$saleBill->sale_bill_notes->isEmpty())
                                        value="{{$saleBill->sale_bill_notes[0]->notes}}" @endif type="text"
                                        class="form-control" name="notes[]"/>
                                </div>
                            </div>
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label class="d-block">
                                        الملاحظة رقم 2
                                    </label>
                                    <input
                                        @if(!empty($saleBill->sale_bill_notes[1]) && !$saleBill->sale_bill_notes->isEmpty())
                                        value="{{$saleBill->sale_bill_notes[1]->notes}}" @endif type="text"
                                        class="form-control" name="notes[]"/>
                                </div>
                            </div>
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label class="d-block">
                                        الملاحظة رقم 3
                                    </label><input
                                        @if(!empty($saleBill->sale_bill_notes[2]) && !$saleBill->sale_bill_notes->isEmpty())
                                        value="{{$saleBill->sale_bill_notes[2]->notes}}" @endif type="text"
                                        class="form-control" name="notes[]"/>
                                </div>
                            </div>
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label class="d-block">
                                        الملاحظة رقم 4
                                    </label>
                                    <input
                                        @if(!empty($saleBill->sale_bill_notes[3]) && !$saleBill->sale_bill_notes->isEmpty())
                                        value="{{$saleBill->sale_bill_notes[3]->notes}}" @endif type="text"
                                        class="form-control" name="notes[]"/>
                                </div>
                            </div>
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label class="d-block">
                                        الملاحظة رقم 5
                                    </label><input
                                        @if(!empty($saleBill->sale_bill_notes[4]) && !$saleBill->sale_bill_notes->isEmpty())
                                        value="{{$saleBill->sale_bill_notes[4]->notes}}" @endif type="text"
                                        class="form-control" name="notes[]"/>
                                </div>
                            </div>
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label class="d-block">
                                        الملاحظة رقم 6
                                    </label>
                                    <input
                                        @if(!empty($saleBill->sale_bill_notes[5]) && !$saleBill->sale_bill_notes->isEmpty())
                                        value="{{$saleBill->sale_bill_notes[5]->notes}}" @endif type="text"
                                        class="form-control" name="notes[]"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="myForm" type="submit" class="btn btn-md btn-success">
                        <i class="fa fa-save"></i>
                        حفظ الملاحظات
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>
                        اغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="final_total" value="{{ $saleBill->final_total }}"/>
    <input type="hidden" id="paid_amount" value="{{ $saleBill->paid }}"/>
    <input type="hidden" id="product" placeholder="product" name="product"/>
    <input type="hidden" id="total" placeholder="اجمالى قبل الخصم" name="total"/>
    <input type="hidden" value="0" id="check"/>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>

        $('.pay_cash').on('click', function () {
            let company_id = $('#company_id').val();
            let outer_client_id = $('#outer_client_id').val();
            let sale_bill_number = $('#sale_bill_number').val();
            let date = $('#date').val();
            let time = $('#time').val()
            let cash_number = $('#cash_number').val();
            let amount = $('#amount').val();
            let safe_id = $('#safe_id').val();
            let bank_id = $('#bank_id').val();
            let bank_check_number = $('#bank_check_number').val();
            let notes = $('#bank_notes').val();
            let payment_method = $('#payment_method').val();
            if (payment_method == "cash" && safe_id == "") {
                alert('اختر الخزنة اولا');
            } else if (payment_method == "bank" && bank_id == "") {
                alert('اختر البنك اولا ');
            } else if (payment_method == "") {
                alert('اختر طريقة الدفع اولا ');
            } else {
                $.post("{{ route('client.store.cash.outerClients.SaleBill', 'test') }}", {
                    outer_client_id: outer_client_id,
                    company_id: company_id,
                    bill_id: sale_bill_number,
                    date: date,
                    time: time,
                    cash_number: cash_number,
                    amount: amount,
                    safe_id: safe_id,
                    bank_id: bank_id,
                    bank_check_number: bank_check_number,
                    notes: notes,
                    payment_method: payment_method,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    if (data.status == true) {
                        $('<div class="alert alert-dark alert-sm"> ' + data.msg + '</div>').insertAfter(
                            '#company_id');
                        $('.delete_pay').on('click', function () {
                            let payment_method = $(this).attr('payment_method');
                            let cash_id = $(this).attr('cash_id');
                            $.post("{{ route('sale_bills.pay.delete') }}", {
                                '_token': "{{ csrf_token() }}",
                                payment_method: payment_method,
                                cash_id: cash_id,
                            }, function (data) {

                            });
                            $(this).parent().hide();
                        });
                    } else {
                        $('<br/><br/> <p class="alert alert-dark alert-sm"> ' + data.msg + '</p>')
                            .insertAfter('#company_id');
                    }
                });
            }
        });
        $('.delete_pay').on('click', function () {
            let payment_method = $(this).attr('payment_method');
            let cash_id = $(this).attr('cash_id');
            $.post("{{ route('sale_bills.pay.delete') }}", {
                '_token': "{{ csrf_token() }}",
                payment_method: payment_method,
                cash_id: cash_id,
            }, function (data) {

            });
            $(this).parent().parent().hide();

        });
        $('#outer_client_id').on('change', function () {
            let outer_client_id = $(this).val();
            if (outer_client_id != "") {
                $('.outer_client_details').fadeIn(200);
                $.post("{{ url('/client/sale-bills/getOuterClientDetails') }}", {
                    outer_client_id: outer_client_id,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    $('#category').html(data.category);
                    $('#balance_before').html(data.balance_before);
                    $('#client_national').html(data.client_national);
                    $('#tax_number').html(data.tax_number);
                    $('#shop_name').html(data.shop_name);
                    $('#client_phone').html(data.client_phone);
                    $('#client_address').html(data.client_address);
                });
            } else {
                $('.outer_client_details').fadeOut(200);
            }
        });
        $('#store_id').on('change', function () {
            let store_id = $(this).val();
            if (store_id != "" || store_id != "0") {
                $('.options').fadeIn(200);
                $.post("{{ url('/client/sale-bills/getProducts') }}", {
                    store_id: store_id,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    $('select#product_id').html(data);
                    $('select#product_id').selectpicker('refresh');
                });
            } else {
                $('.options').fadeOut(200);
            }
        });
        $('#product_id').on('change', function () {
            $('#sector').prop('checked', false);
            $('#quantity').val('');
            $('#quantity_price').val('');
            let sale_bill_number = $('#sale_bill_number').val();
            let product_id = $(this).val();
            $.post("{{ url('/client/sale-bills/get') }}", {
                product_id: product_id,
                sale_bill_number: sale_bill_number,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                $('#wholesale').prop('checked', true);
                $('input#product_price').val(data.wholesale_price);
                $('input#quantity_price').val(data.wholesale_price);
                $('input#quantity').val("1");
                $('select#unit_id').val(data.unit_id);
                $('input#quantity').attr('max', data.first_balance);
                $('.available').html('الكمية المتاحة : ' + data.first_balance);
            });
        });
        $('#wholesale').on('click', function () {
            let product_id = $('#product_id').val();
            $.post("{{ url('/client/sale-bills/get') }}", {
                product_id: product_id,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                $('input#product_price').val(data.wholesale_price);
                let quantity = $('#quantity').val();
                let quantity_price = quantity * data.wholesale_price;
                $('#quantity_price').val(quantity_price);
            });
        });
        $('#sector').on('click', function () {
            let product_id = $('#product_id').val();
            $.post("{{ url('/client/sale-bills/get') }}", {
                product_id: product_id,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                $('input#product_price').val(data.sector_price);
                let quantity = $('#quantity').val();
                let quantity_price = quantity * data.sector_price;
                $('#quantity_price').val(quantity_price);
            });
        });
        $('#quantity').on('keyup change', function () {
            let product_id = $('#product_id').val();
            let product_price = $('#product_price').val();
            let quantity = $(this).val();
            let quantity_price = quantity * product_price;
            $('#quantity_price').val(quantity_price);
        });
        $('#product_price').on('keyup change', function () {
            let product_id = $('#product_id').val();
            let product_price = $(this).val();
            let quantity = $('#quantity').val();
            let quantity_price = quantity * product_price;
            $('#quantity_price').val(quantity_price);
        });


        //add-new-sale-bill button --- اضافة فاتورة بيع جديدة.
        $('#add').on('click', function () {
            let outer_client_id = $('#outer_client_id').val();
            if (outer_client_id == null) {
                alert('يجب اختيار العميل');
                return false;
            }
            let sale_bill_number = $('#sale_bill_number').val();
            let product_id = $('#product_id').val();
            let product_price = $('#product_price').val();
            let quantity = $('#quantity').val();
            let date = $('#date').val();
            let time = $('#time').val();
            let notes = $('#notes').val();
            let quantity_price = quantity * product_price;
            let unit_id = $('#unit_id').val();
            let first_balance = parseFloat($('#quantity').attr('max'));
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            let value_added_tax = $('#value_added_tax').val();

            if (product_id == "" || product_id <= "0") {
                alert("لابد ان تختار المنتج أولا");
            } else if (unit_id == "" || unit_id == "0") {
                alert("اختر الوحدة");
            } else {

                $.post("{{ url('/client/sale-bills/post') }}", {
                    outer_client_id: outer_client_id,
                    value_added_tax: value_added_tax,
                    sale_bill_number: sale_bill_number,
                    product_id: product_id,
                    product_price: product_price,
                    quantity: quantity,
                    unit_id: unit_id,
                    quantity_price: quantity_price,
                    date: date,
                    notes: notes,
                    time: time,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    $('#outer_client_id').attr('disabled', true).addClass('disabled');
                    $('#product_id').val('').trigger('change');
                    $('#unit_id').val('');
                    $('#discount_type').attr('disabled', false);
                    $('.print_btn').removeClass('disabled');
                    $('.pay_btn').attr('disabled', false);
                    $('.close_btn').attr('disabled', false);
                    $('.save_btn1').removeClass('disabled');
                    $('.save_btn2').removeClass('disabled');
                    $('.send_btn').removeClass('disabled');
                    $('.add_extra_notes').removeClass('disabled');
                    $('#discount_value').attr('disabled', false);
                    $('#exec_discount').attr('disabled', false);
                    $('#extra_type').attr('disabled', false);
                    $('#extra_value').attr('disabled', false);
                    $('#exec_extra').attr('disabled', false);
                    $('#value_added_tax').attr('disabled', true).addClass('disabled');
                    $('.available').html("");
                    $('#product_price').val('0');
                    $('#quantity').val('');
                    $('#quantity_price').val('');
                    if (data.status == true) {

                        //-----show success msg.------//
                        $('.box_success').removeClass('d-none').fadeIn(200);
                        $('.msg_success').html(data.msg);
                        $('.box_success').delay(3000).fadeOut(300);

                        //-----get and show added elements.-----//
                        $.post("{{ url('/client/sale-bills/elements') }}", {
                            "_token": "{{ csrf_token() }}",
                            sale_bill_number: sale_bill_number
                        }, function (elements) {
                            $('.bill_details').html(elements);
                        });

                        //-----apply discount-----//
                        $.post("{{ url('/client/sale-bills/discount') }}", {
                            "_token": "{{ csrf_token() }}",
                            sale_bill_number: sale_bill_number,
                            discount_type: discount_type,
                            discount_value: discount_value
                        }, function (data) {
                            $('.after_totals').html(data);
                        });

                        //-----apply extra_value which is shipping discount-----//
                        $.post("{{ url('/client/sale-bills/extra') }}", {
                            "_token": "{{ csrf_token() }}",
                            sale_bill_number: sale_bill_number,
                            extra_type: extra_type,
                            extra_value: extra_value
                        }, function (data) {
                            $('.after_totals').html(data);
                        });

                        $.post("{{ url('/client/sale-bills/refresh') }}", {
                            "_token": "{{ csrf_token() }}",
                            sale_bill_number: sale_bill_number,
                        }, function (data) {
                            $('#final_total').val(data.final_total);
                        });

                    } else {
                        $('.box_error').removeClass('d-none').fadeIn(200);
                        $('.msg_error').html(data.msg);
                        $('.box_error').delay(3000).fadeOut(300);


                        $.post("{{ url('/client/sale-bills/elements') }}", {
                            "_token": "{{ csrf_token() }}",
                            sale_bill_number: sale_bill_number
                        }, function (elements) {
                            $('.bill_details').html(elements);
                        });

                        $.post("{{ url('/client/sale-bills/discount') }}", {
                            "_token": "{{ csrf_token() }}",
                            sale_bill_number: sale_bill_number,
                            discount_type: discount_type,
                            discount_value: discount_value
                        }, function (data) {
                            alert('تم تطبيق الخصم');
                            $('.after_totals').html(data);
                        });

                        $.post("{{ url('/client/sale-bills/extra') }}", {
                            "_token": "{{ csrf_token() }}",
                            sale_bill_number: sale_bill_number,
                            extra_type: extra_type,
                            extra_value: extra_value
                        }, function (data) {
                            $('.after_totals').html(data);
                        });


                        $.post("{{ url('/client/sale-bills/refresh') }}", {
                            "_token": "{{ csrf_token() }}",
                            sale_bill_number: sale_bill_number,
                        }, function (data) {
                            $('#final_total').val(data.final_total);
                        });


                    }
                });
            }

        });

        // apply discount //
        $('#exec_discount').on('click', function () {
            let sale_bill_number = $('#sale_bill_number').val();
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            let discount_note = $('#discount_note').val();

            // apply discount //
            $.post("{{ url('/client/sale-bills/discount') }}", {
                "_token": "{{ csrf_token() }}",
                sale_bill_number: sale_bill_number,
                discount_type: discount_type,
                discount_value: discount_value,
                discount_note: discount_note
            }, function (data) {
                alert('تم تطبيق الخصم');
                $('.after_totals').html(data);
            });

            // refresh //
            $.post("{{ url('/client/sale-bills/refresh') }}", {
                "_token": "{{ csrf_token() }}",
                sale_bill_number: sale_bill_number,
            }, function (data) {
                $('#final_total').val(data.final_total);
            });
        });

        $('.pay_btn').on('click', function () {
            let final_total = $('#final_total').val();
            let paid_amount = $('#paid_amount').val();
            $('#amount').val(final_total - paid_amount);
        })

        $('.edit_element').on('click', function () {
            let element_id = $(this).attr('element_id');
            let sale_bill_number = $(this).attr('sale_bill_number');

            $.post("{{ url('/client/sale-bills/edit-element') }}", {
                "_token": "{{ csrf_token() }}",
                sale_bill_number: sale_bill_number,
                element_id: element_id
            }, function (data) {
                $('#product_id').val(data.product_id);
                $('#product_id').selectpicker('refresh');
                $('#product_price').val(data.product_price);
                $('#unit_id').val(data.unit_id);
                $('#quantity').val(data.quantity);
                $('#quantity_price').val(data.quantity_price);
                let product_id = data.product_id;
                $.post("{{ url('/client/sale-bills/get-edit') }}", {
                    product_id: product_id,
                    sale_bill_number: sale_bill_number,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    $('input#quantity').attr('max', data.first_balance);
                    $('.available').html('الكمية المتاحة : ' + data.first_balance);
                });
                $('#add').hide();
                $('#edit').show();
                $('#edit').attr('element_id', element_id);
                $('#edit').attr('sale_bill_number', sale_bill_number);

            });
        });

        $('#edit').on('click', function () {
            let element_id = $(this).attr('element_id');
            let sale_bill_number = $(this).attr('sale_bill_number');

            let product_id = $('#product_id').val();
            let product_price = $('#product_price').val();
            let quantity = $('#quantity').val();
            let quantity_price = $('#quantity_price').val();
            let unit_id = $('#unit_id').val();

            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            let first_balance = parseFloat($('#quantity').attr('max'));
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            let value_added_tax = $('#value_added_tax').val();
            if (!isNaN(first_balance)) {
                if (product_id == "" || product_id <= "0") {
                    alert("لابد ان تختار المنتج أولا");
                } else if (product_price == "" || product_price == "0") {
                    alert("لم يتم اختيار سعر المنتج");
                } else if (quantity == "" || quantity <= "0" || quantity > first_balance) {
                    alert("الكمية غير مناسبة");
                } else if (quantity_price == "" || quantity_price == "0") {
                    alert("الكمية غير مناسبة او الاجمالى غير صحيح");
                } else if (unit_id == "" || unit_id == "0") {
                    alert("اختر الوحدة");
                } else {
                    $.post('/client/sale-bills/element/update', {
                        '_token': "{{ csrf_token() }}",
                        element_id: element_id,
                        value_added_tax: value_added_tax,
                        product_id: product_id,
                        product_price: product_price,
                        quantity: quantity,
                        quantity_price: quantity_price,
                        unit_id: unit_id,
                    }, function (data) {
                        $.post('/client/sale-bills/elements', {
                            '_token': "{{ csrf_token() }}",
                            sale_bill_number: sale_bill_number
                        }, function (elements) {
                            $('.bill_details').html(elements);
                        });

                        $('#add').show();
                        $('#edit').hide();
                        $('#product_id').val('').trigger('change');
                        $('#unit_id').val('');
                        $('.available').html("");
                        $('#product_price').val('0');
                        $('#quantity').val('');
                        $('#quantity_price').val('');
                    });
                    $.post('/client/sale-bills/discount', {
                        '_token': "{{ csrf_token() }}",
                        sale_bill_number: sale_bill_number,
                        discount_type: discount_type,
                        discount_value: discount_value
                    }, function (data) {
                        alert('تم تطبيق الخصم');
                        $('.after_totals').html(data);
                    });

                    $.post('/client/sale-bills/extra', {
                        '_token': "{{ csrf_token() }}",
                        sale_bill_number: sale_bill_number,
                        extra_type: extra_type,
                        extra_value: extra_value
                    }, function (data) {
                        $('.after_totals').html(data);
                    });
                    $.post("{{ url('/client/sale-bills/refresh') }}", {
                        "_token": "{{ csrf_token() }}",
                        sale_bill_number: sale_bill_number,
                    }, function (data) {
                        $('#final_total').val(data.final_total);
                    });
                }
            } else {

                $.post('/client/sale-bills/element/update', {
                    '_token': "{{ csrf_token() }}",
                    element_id: element_id,
                    product_id: product_id,
                    value_added_tax: value_added_tax,
                    product_price: product_price,
                    quantity: quantity,
                    quantity_price: quantity_price,
                    unit_id: unit_id,
                }, function (data) {
                    $.post('/client/sale-bills/elements', {
                        '_token': "{{ csrf_token() }}",
                        sale_bill_number: sale_bill_number
                    }, function (elements) {
                        $('.bill_details').html(elements);
                    });
                    $('#add').show();
                    $('#edit').hide();
                    $('#product_id').val('').trigger('change');
                    $('#unit_id').val('');
                    $('.available').html("");
                    $('#product_price').val('0');
                    $('#quantity').val('');
                    $('#quantity_price').val('');
                });

                $.post('/client/sale-bills/discount', {
                    '_token': "{{ csrf_token() }}",
                    sale_bill_number: sale_bill_number,
                    discount_type: discount_type,
                    discount_value: discount_value
                }, function (data) {
                    alert('تم تطبيق الخصم');
                    $('.after_totals').html(data);
                });

                $.post('/client/sale-bills/extra', {
                    '_token': "{{ csrf_token() }}",
                    sale_bill_number: sale_bill_number,
                    extra_type: extra_type,
                    extra_value: extra_value
                }, function (data) {
                    $('.after_totals').html(data);
                });

                $.post("{{ url('/client/sale-bills/refresh') }}", {
                    "_token": "{{ csrf_token() }}",
                    sale_bill_number: sale_bill_number,
                }, function (data) {
                    $('#final_total').val(data.final_total);
                });
            }

        });

        $('.remove_element').on('click', function () {
            let element_id = $(this).attr('element_id');
            let sale_bill_number = $(this).attr('sale_bill_number');
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();

            $.post('/client/sale-bills/element/delete', {
                '_token': "{{ csrf_token() }}",
                element_id: element_id
            }, function (data) {
                $.post('/client/sale-bills/elements', {
                    '_token': "{{ csrf_token() }}",
                    sale_bill_number: sale_bill_number
                }, function (elements) {
                    $('.bill_details').html(elements);
                });
            });

            $.post('/client/sale-bills/discount', {
                '_token': "{{ csrf_token() }}",
                sale_bill_number: sale_bill_number,
                discount_type: discount_type,
                discount_value: discount_value
            }, function (data) {
                $('.after_totals').html(data);
            });

            $.post('/client/sale-bills/extra', {
                '_token': "{{ csrf_token() }}",
                sale_bill_number: sale_bill_number,
                extra_type: extra_type,
                extra_value: extra_value
            }, function (data) {
                $('.after_totals').html(data);
            });

            $.post("{{ url('/client/sale-bills/refresh') }}", {
                "_token": "{{ csrf_token() }}",
                sale_bill_number: sale_bill_number,
            }, function (data) {
                $('#final_total').val(data.final_total);
            });

            $(this).parent().parent().fadeOut(300);
        });

        $('#exec_extra').on('click', function () {
            let sale_bill_number = $('#sale_bill_number').val();
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            $.post("{{ url('/client/sale-bills/extra') }}", {
                "_token": "{{ csrf_token() }}",
                sale_bill_number: sale_bill_number,
                extra_type: extra_type,
                extra_value: extra_value
            }, function (data) {
                $('.after_totals').html(data);
            });

            $.post("{{ url('/client/sale-bills/refresh') }}", {
                "_token": "{{ csrf_token() }}",
                sale_bill_number: sale_bill_number,
            }, function (data) {
                $('#final_total').val(data.final_total);
            });
        });

        $('#payment_method').on('change', function () {
            let payment_method = $(this).val();
            if (payment_method == "cash") {
                $('.cash').show();
                $('.bank').hide();
            } else if (payment_method == "bank") {
                $('.bank').show();
                $('.cash').hide();
            } else {
                $('.bank').hide();
                $('.cash').hide();
            }
        });

        window.addEventListener("pageshow", function (event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
            if (historyTraversal) {
                // Handle page restore.
                window.location.reload();
            }
        });

        $('#value_added_tax').on('change', function () {
            let token = "{{$saleBill->token}}";
            let valueTax = $(this).val();
            $.post("{{ route('updateInvTaxValue') }}", {
                "_token": "{{ csrf_token() }}",
                token: token,
                value_added_tax: valueTax,
            }, function () {
                location.reload()
            });
        });
    </script>
@endsection
