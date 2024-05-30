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
                            <div class="row col-12 p-0 pb-2 pl-1 border-bottom border-secondary">
                                <div class="col-md-6 pr-0">
                                    <label> التاريخ <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>

                                {{-- <div class="col-md-6 pr-0">
                                    <label> الزبون/ المورد <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="الزبون/ المورد" class="form-control"
                                        name="payer_name" style="height: 43px" required>
                                </div> --}}

                                <div class="col-md-12 mt-1 pr-0">
                                    <label> الملاحظات <span class="text-danger">*</span></label>
                                    <textarea required class="form-control" placeholder="الملاحظات" name="description"></textarea>
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
                                                    <option value="">اختر الحساب</option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}">{{ $account->account_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="account-error text-danger"></span>
                                            </td>

                                            <td>
                                                <input type="number" class="form-control debit" name="debit[]"
                                                    value="0">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control credit" name="credit[]"
                                                    value="0">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="notes[]">
                                            </td>
                                            <td>
                                                <input type="button" class="mt-1 btn btn-danger btn-sm deleteRow"
                                                    value="X" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {{-- <select required name="account[]" class="form-control">
                                                    @include('client.journal.accounts')
                                                </select> --}}
                                                <select required name="account[]" class="form-control">
                                                    <option value="">اختر الحساب</option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}">{{ $account->account_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="account-error text-danger"></span>
                                            </td>

                                            <td>
                                                <input type="number" class="form-control debit" name="debit[]"
                                                    value="0">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control credit" name="credit[]"
                                                    value="0">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="notes[]">
                                            </td>
                                            <td>
                                                <input type="button" class="mt-1 btn btn-danger btn-sm deleteRow"
                                                    value="X" />
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
                                            <td id="errorCell" style="color: red;"></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <button type="button" class="btn btn-primary addNewRowHandler">
                                    <i class="fa fa-plus"></i>
                                    اضافة صف جديد
                                </button>
                            </div>
                        </div>
                        <div class="col-12 text-center border-top border-secondary mt-1 pt-2 pr-0 pl-0">
                            <button class="btn btn-success w-100 font-weight-bold"
                                type="submit">{{ __('main.add') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        let selectedAccountIds = [];

        function attachRowEvents() {
            $('.debit, .credit, .notes').off('input').on('input', function() {
                const row = $(this).closest('tr');
                const accountField = row.find('select[name="account[]"]');
                const accountError = row.find('.account-error');
                const debitField = row.find('.debit');
                const creditField = row.find('.credit');

                // Show error if account is not selected
                if (!accountField.val()) {
                    accountError.text('Please select an account first.');
                } else {
                    accountError.text('');
                }

                if ($(this).hasClass('debit') && $(this).val() !== '') {
                    creditField.prop('disabled', true).val(0);
                } else if ($(this).hasClass('credit') && $(this).val() !== '') {
                    debitField.prop('disabled', true).val(0);
                } else {
                    debitField.prop('disabled', false);
                    creditField.prop('disabled', false);
                }

                calculateTotal();
            });

            $('.deleteRow').off('click').on('click', function() {
                $(this).closest('tr').remove();
                updateSelectedAccountIds();
                calculateTotal();
            });

            $('select[name="account[]"]').off('change').on('change', function() {
                const row = $(this).closest('tr');
                const accountError = row.find('.account-error');
                if ($(this).val()) {
                    accountError.text('');
                }
                updateSelectedAccountIds();
            });
        }

        function calculateTotal() {
            let totalDebit = 0;
            let totalCredit = 0;

            $('.tbodyJournals tr').each(function() {
                const debitValue = parseFloat($(this).find('.debit').val()) || 0;
                const creditValue = parseFloat($(this).find('.credit').val()) || 0;

                totalDebit += debitValue;
                totalCredit += creditValue;
            });

            $('#totalDebit').text(totalDebit.toFixed(2));
            $('#totalCredit').text(totalCredit.toFixed(2));

            if (totalDebit !== totalCredit) {
                $('#errorCell').text('Error: Total debit is not equal to total credit.');
            } else {
                $('#errorCell').text('');
            }
        }

        function updateSelectedAccountIds() {
            selectedAccountIds = [];
            $('select[name="account[]"]').each(function() {
                let accountId = $(this).val();
                if (accountId !== '') {
                    selectedAccountIds.push(accountId);
                }
            });
            updateAccountOptions();
        }

        function updateAccountOptions() {
            $('select[name="account[]"]').each(function() {
                let currentVal = $(this).val();
                $(this).find('option').each(function() {
                    if ($(this).val() !== '' && $(this).val() !== currentVal) {
                        if (selectedAccountIds.includes($(this).val())) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    }
                });
            });
        }

        attachRowEvents();

        $(".addNewRowHandler").click(function() {
            updateSelectedAccountIds();
            let newRow =
                '<tr> <td> <select required name="account[]" class="form-control"> <option value="">اختر الحساب</option> @foreach ($accounts as $account) <option value="{{ $account->id }}">{{ $account->account_name }}</option> @endforeach </select> <span class="account-error text-danger"></span> </td> <td> <input type="number" class="form-control debit" name="debit[]" value="0"> </td> <td> <input type="number" class="form-control credit" name="credit[]" value="0"> </td> <td> <input type="text" class="form-control notes" name="notes[]"> </td> <td> <input type="button" class="mt-1 btn btn-danger btn-sm deleteRow" value="X"/> </td> </tr>';
            $(".tbodyJournals").append(newRow);
            updateAccountOptions();
            attachRowEvents();
        });

        $("#storeJournal").submit(function(e) {
            e.preventDefault();

            let journalEntries = [];
            let formIsValid = true;

            $('.tbodyJournals tr').each(function() {
                let account = $(this).find('select[name="account[]"]').val();
                let debit = parseFloat($(this).find('input[name="debit[]"]').val()) || 0;
                let credit = parseFloat($(this).find('input[name="credit[]"]').val()) || 0;
                let notes = $(this).find('input[name="notes[]"]').val() || null;

                if (account) {
                    journalEntries.push({
                        account: account,
                        debit: debit,
                        credit: credit,
                        notes: notes
                    });
                } else if (debit !== 0 || credit !== 0 || notes) {
                    $(this).find('.account-error').text('Please select an account first.');
                    formIsValid = false;
                } else {
                    $(this).find('.account-error').text('');
                }
            });

            if (!formIsValid) {
                alert('Please fix the errors before submitting.');
                return;
            }

            let formData = new FormData(this);
            formData.append('journalEntries', JSON.stringify(journalEntries));

            // Remove the unnecessary arrays from the FormData
            formData.delete('account[]');
            formData.delete('debit[]');
            formData.delete('notes[]');
            formData.delete('credit[]');

            $.ajax({
                type: "POST",
                url: "{{ route('client.journal.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: (data) => {
                    alert('تمت العملية بنجاح');
                },
                error: (data) => {
                    alert('حدث خطأ ما');
                }
            });
        });
    });
</script>
