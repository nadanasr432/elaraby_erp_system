@extends('admin.layouts.app-main')
<style>

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

    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('admin.companies.index') }}">
                            عودة
                            للخلف</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            تحديث بيانات الشركة
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                          action="{{route('admin.companies.update',$company->id)}}" enctype="multipart/form-data"
                          method="post">
                        @csrf
                        @method('PATCH')
                        <h5 class="col-lg-12 d-block mb-2">البيانات الاساسية</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> اسم الشركة <span class="text-danger">*</span></label>
                                <input dir="rtl" value="{{$company->company_name}}" required class="form-control"
                                       name="company_name" type="text">
                            </div>
                            <div class="col-md-4">
                                <label> الحالة <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="">
                                    <option @if($company->status == "active") selected @endif value="active">مفعل</option>
                                    <option @if($company->status == "blocked") selected @endif value="blocked">معطل</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="d-block" dir="rtl"> ملاحظات ( اكتب سبب التعطيل ) </label>
                                <input dir="rtl" value="{{$company->notes}}" class="form-control"
                                       name="notes" type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">تحديث</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
