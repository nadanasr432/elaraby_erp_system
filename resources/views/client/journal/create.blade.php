@extends('client.layouts.app-main')
<style>
    select {
        font-weight: bold;
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

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!------HEADER----->
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold">
                            اضافة قيود اليومية
                        </h3>
                        <a class="btn btn-danger btn-sm pull-left p-1" href="{{ route('client.journal.get') }}">
                            {{ __('main.back') }}
                        </a>
                    </div>
                </div>

                <!------HEADER----->
                <div class="card-body p-2">
                    <form id="storeJournal" action="{{ route('client.journal.store') }}" method="post">
                        @csrf
                        <div class="row p-0 mb-1">
                            <!---ROW1--->
                            <div class="row  col-12 p-0 pb-2 pl-1 border-bottom border-secondary">
                                <div class="col-md-6 pr-0">
                                    <label> التاريخ <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>

                                <div class="col-md-6 pr-0">
                                    <label> الزبون/ المورد <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="الزبون/ المورد" class="form-control"
                                           name="payer_name" style="height: 43px" required>
                                </div>

                                <div class="col-md-12 mt-1 pr-0">
                                    <label> الملاحظات <span class="text-danger">*</span></label>
                                    <textarea required class="form-control" placeholder="الملاحظات"
                                              name="description"></textarea>
                                </div>
                            </div>

                            <!---ROW2--->
                            <div class="table-responsive pr-1 pl-1">
                                <table class="table mt-2">
                                    <thead class="table-primary">
                                    <tr>
                                        <th scope="col">الحساب</th>
                                        <th scope="col">مدين</th>
                                        <th scope="col">دائن</th>
                                        <th scope="col">ملاحظات</th>
                                        <th scope="col">تحكم</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbodyJournals">
                                    <tr>
                                        <td>
                                            <select required name="account[]" class="form-control">
                                                @include('client.journal.accounts')
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="debit[]" value="0">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="credit[]" value="0">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="notes[]">
                                        </td>
                                        <td>
                                            <input
                                                type="button" class="mt-1 btn btn-danger btn-sm deleteRow"
                                                value="X"/>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center">
                                            المجموع:
                                            <span id="totalDebit">0</span>
                                        </td>
                                        <td style="text-align: center">
                                            المجموع:
                                            <span id="totalCredit">0</span>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>

                                <button
                                    type="button" class="btn btn-primary addNewRowHandler">
                                    <i class="fa fa-plus"></i>
                                    اضافة صف جديد
                                </button>
                            </div>
                        </div>
                        <div class="col-12 text-center border-top border-secondary mt-1 pt-2 pr-0 pl-0">
                            <button class="btn btn-success w-100 font-weight-bold" type="submit">{{ __('main.add') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $(".addNewRowHandler").click(function () {
            let accountOptions = '<option value="">اختر الحساب</option> <option value="0">النقدية في الخزينة</option> <option value="1"> العهد النقدية</option> <option value="2"> حساب البنك الجاري - اسم البنك</option> <option value="3"> المدينون</option> <option value="4"> تأمين طبي مقدم</option> <option value="5"> إيجار مقدم</option> <option value="6"> مدفوعات مقدمة للموظفين</option> <option value="7"> المخزون</option> <option value="8"> الأراضي</option> <option value="9"> المباني</option> <option value="10"> المعدات</option> <option value="11"> أجهزة مكتبية وطابعات</option> <option value="12"> الأصول غير الملموسة</option> <option value="13"> العقارات الاستثمارية</option> <option value="14"> الدائنون</option> <option value="15"> مصروفات مستحقة</option> <option value="16"> الرواتب المستحقة</option> <option value="17"> قروض قصيرة الأجل</option> <option value="18"> ضريبة القيمة المضافة المستحقة</option> <option value="19"> الضرائب المستحقة</option> <option value="20"> إيرادات غير مكتسبة</option> <option value="21"> مستحقات المؤسسة العامة للتأمينات الاجتماعية</option> <option value="22"> مجمع استهلاك المباني</option> <option value="23"> مجمع استهلاك المعدات</option> <option value="24"> مجمع استهلاك أجهزة مكتبية وطابعات</option> <option value="25"> مخصص مكافأة نهاية الخدمة</option> <option value="26"> قروض طويلة أجل</option> <option value="27"> رأس المال المسجل</option> <option value="28"> رأس المال الإضافي المدفوع</option> <option value="29"> أرصدة افتتاحية</option> <option value="30"> احتياطي نظامي</option> <option value="31"> احتياطي ترجمة عملات أجنبية</option> <option value="32"> الأرباح والخسائر العاملة</option> <option value="33"> الأرباح المبقاة (أو الخسائر)</option> <option value="34"> إيرادات المبيعات/ الخدمات</option> <option value="35"> تكلفة البضاعة المباعة</option> <option value="36"> رواتب وأجور</option> <option value="37"> عمولات البيع</option> <option value="38"> الرواتب والرسوم الإدارية</option> <option value="39"> إيرادات أخرى</option> <option value="40"> شحن وتخليص جمركي</option> <option value="41"> تأمين طبي</option> <option value="42"> مصاريف تسويقية ودعائية</option> <option value="43"> مصاريف الإيجار</option> <option value="44"> عمولات وحوافز</option> <option value="45"> تذاكر سفر</option> <option value="46"> التأمينات الاجتماعية</option> <option value="47"> الرسوم الحكومية</option> <option value="48"> رسوم واشتراكات</option> <option value="49"> مصاريف مكتبية ومطبوعات</option> <option value="50"> مصاريف خدمات المكتب</option> <option value="51"> مصاريف ضيافة</option> <option value="52"> عمولات بنكية</option> <option value="53"> مصاريف أخرى</option> <option value="54"> مصروف إهلاك المباني</option> <option value="55"> مصروف إهلاك المعدات</option> <option value="56"> مصروف إهلاك أجهزة مكتبية وطابعات</option> <option value="57"> مصروف نقل ومواصلات</option> <option value="58"> الضرائب</option> <option value="59"> الزكاة</option> <option value="60"> ترجمة عملات أجنبية</option> <option value="61"> فوائد</option>';
            let newRow = '<tr> <td> <select required name="account[]" class="form-control"> ' + accountOptions + ' </select> </td> <td> <input type="number" class="form-control" name="debit[]" value="0"> </td> <td> <input type="number" class="form-control" name="credit[]" value="0"> </td> <td> <input type="text" class="form-control" name="notes[]"> </td> <td> <input type="button" class="mt-1 btn btn-danger btn-sm deleteRow" value="X"/> </td> </tr>';
            $(".tbodyJournals").append(newRow);
        });
        $(".deleteRow").click(function () {
            $(this).parent().parent().remove();
        });

        $("#storeJournal").submit(function (e) {
            e.preventDefault()
            //start ajax
            $.ajax({
                type: "POST",
                url: "{{ route('client.journal.store') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: (data) => {
                }

            });
        });
    });

</script>
