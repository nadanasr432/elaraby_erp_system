@extends('admin.layouts.app-main')
<style>

</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
{{--                            <a class="btn pull-left btn-primary btn-sm"--}}
{{--                               href="{{ route('admin.payments.create') }}"><i--}}
{{--                                    class="fa fa-plus"></i> اضافة مدفوعات جديدة </a>--}}
                            <h5 class="pull-right alert alert-sm alert-success">عرض كل المدفوعات </h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover"
                               id="example-table">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الشركة</th>
                                <th class="text-center"> المبلغ المدفوع</th>
                                <th class="text-center">التاريخ</th>
                                <th class="text-center">الوقت</th>
{{--                                <th class="text-center">تحكم</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($payments as $key => $payment)
                                @if(!$payment->company->clients->isEmpty())
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $payment->company->company_name}}</td>
                                        <td>{{ $payment->amount}}</td>
                                        <td>{{ $payment->date}}</td>
                                        <td>{{ $payment->time}}</td>
{{--                                        <td>--}}
{{--                                            <a href="{{ route('admin.payments.edit', $payment->id) }}"--}}
{{--                                               class="btn btn-sm btn-info" data-toggle="tooltip"--}}
{{--                                               title="تعديل" data-placement="top"><i class="fa fa-edit"></i></a>--}}
{{--                                            <a class="modal-effect btn btn-sm btn-danger delete_payment"--}}
{{--                                               payment_id="{{ $payment->id }}"--}}
{{--                                               payment_name="{{ $payment->amount }}" data-toggle="modal"--}}
{{--                                               href="#modaldemo9"--}}
{{--                                               title="delete"><i--}}
{{--                                                    class="fa fa-trash"></i></a>--}}
{{--                                        </td>--}}
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

{{--        <div class="modal" id="modaldemo9">--}}
{{--            <div class="modal-dialog modal-dialog-centered" payment="document">--}}
{{--                <div class="modal-content modal-content-demo">--}}
{{--                    <div class="modal-header text-center">--}}
{{--                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف مدفوعات</h6>--}}
{{--                        <button aria-label="Close" class="close"--}}
{{--                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>--}}
{{--                    </div>--}}
{{--                    <form action="{{ route('admin.payments.destroy', 'test') }}" method="post">--}}
{{--                        {{ method_field('delete') }}--}}
{{--                        {{ csrf_field() }}--}}
{{--                        <div class="modal-body">--}}
{{--                            <p>هل انت متأكد من الحذف ?</p><br>--}}
{{--                            <input type="hidden" name="paymentid" id="paymentid">--}}
{{--                            <input class="form-control" name="paymentname" id="paymentname" type="text" readonly>--}}
{{--                        </div>--}}
{{--                        <div class="modal-footer">--}}
{{--                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>--}}
{{--                            <button type="submit" class="btn btn-danger">حذف</button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        // $('.delete_payment').on('click', function () {
        //     var payment_id = $(this).attr('payment_id');
        //     var payment_name = $(this).attr('payment_name');
        //     $('.modal-body #paymentid').val(payment_id);
        //     $('.modal-body #paymentname').val(payment_name);
        // });
    });
</script>
