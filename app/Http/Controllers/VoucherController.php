<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Models\accounting_tree;
use App\Models\Transaction;

class VoucherController extends Controller
{
    public function get_voucher_entries()
    {
    $vouchers = Voucher::all();
        return view('client.voucher.index', compact('vouchers'));
    }

    public function create_voucher_entries()
    {
        $accounts = accounting_tree::all();
        return view('client.voucher.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        // dd(auth::user()->id);
        $request->validate([
            'amount' => 'required',
            'date' => 'required',
            'notation' => 'required',
            'transactions' => 'required|array|min:1',
            'transactions.*.account' => 'required|exists:accounting_trees,id',
            // 'transactions.*.amount' => 'required|numeric',
            'transactions.*.notation' => 'nullable|string',
            // 'transactions.*.type' => 'required|in:0,1',
        ]);
        $voucher = Voucher::create([
            'amount' => $request->amount,
            'date' => $request->date,
            'payment_method' => "cash",
            'notation' => $request->notation,
            'status' => 1,
            'user_id' => auth::user()->id,
            'options' => 0,
        ]);
        foreach ($request->transactions as $transaction) {
            Transaction::create(
                [
                    'accounting_tree_id' => $transaction['account'],
                    'voucher_id' => $voucher->id,
                    'amount' => $transaction['credit'] ? $transaction['credit'] : $transaction['debit'],
                    'notation' => $transaction['notation'],
                    'type' => $transaction['credit'] ? 0 : 1,
                ]
            );
        }
        return response()->json($voucher->id);
    }
}
