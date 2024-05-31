@extends('client.layouts.app-main')
<style>
    #example-table_filter {
        text-align: right;
        float: left;
    }
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
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold">
                            عرض كل قيود اليومية
                        </h3>
                        <a class="btn pull-left btn-primary btn-sm p-1" href="{{ route('client.voucher.create') }}">
                            <i class="fa fa-plus"></i>
                            اضف قيد يومية
                        </a>
                    </div>
                </div>
                {{-- @dump($vouchers->pluck('transactions')) --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover"
                            id="example-table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">تاريخ القيد</th>
                                    <th class="text-center">مدين</th>
                                    <th class="text-center">دائن</th>
                                    <th class="text-center">ملاحظات</th>
                                    <th class="text-center">{{ __('main.amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vouchers as $voucher)
                                    @php
                                        $credits = [];
                                        $depits = [];
                                        if (isset($voucher->transactions)) {
                                            $collection = collect($voucher->transactions);
                                            $grouped = $collection->groupBy('type');
                                            $credits = $grouped->get(0, collect())->all();
                                            $depits = $grouped->get(1, collect())->all();
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $voucher->id }}</td>
                                        <td>{{ $voucher->date ? \Carbon\Carbon::parse($voucher->date)->format('Y-m-d') : '' }}
                                        </td>
                                        <td>
                                        @foreach ( $credits as  $credit)
                                        <span class="badge badge-primary ml-2">{{$credit?->accountingTree->account_name}}</span>
                                        @endforeach
                                        </td>
                                        <td>  @foreach ( $depits as  $depit)
                                            <span class="badge badge-success ml-2">{{$depit?->accountingTree->account_name}}</span>
                                            @endforeach
                                        <td>{{ $voucher->notation }}</td>
                                        <td>{{ $voucher->amount }}</td>
                                        <td> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" voucher="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">{{ __('vouchers.delete-vouchere') }}
                        </h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.delete_voucher').on('click', function() {
            var voucher_id = $(this).attr('voucher_id');
            var voucher_name = $(this).attr('voucher_name');
            $('.modal-body #voucherid').val(voucher_id);
            $('.modal-body #vouchername').val(voucher_name);
        });
    });
</script>
