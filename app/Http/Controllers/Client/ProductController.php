<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\Store;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = Product::where('company_id', $company_id)
            ->where(function ($query) {
                $query->where('first_balance', '>', 0)
                    ->orWhereNull('first_balance');
            })->get();
        $purchase_prices = array();
        $balances = array();
        foreach ($products as $product) {
            $product_price = $product->purchasing_price;
            $product_balance = $product->first_balance;
            array_push($balances, $product_balance);

            //check if the values are integer or not..
            if (is_int($product_balance) && is_int($product_price)) {
                $total_price = $product_price * $product_balance;
                array_push($purchase_prices, $total_price);
            }
        }
        $total_purchase_prices = array_sum($purchase_prices);
        $total_balances = array_sum($balances);
        return view('client.products.index', compact('company', 'total_balances', 'total_purchase_prices', 'company_id', 'products'));
    }


    public function empty()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = Product::where('company_id', $company_id)
            ->where('first_balance', '<=', 0)
            ->get();
        return view('client.products.empty', compact('company', 'company_id', 'products'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = Store::where('company_id', $company_id)->get();
        $categories = Category::where('company_id', $company_id)->get();
        $sub_categories = SubCategory::where('company_id', $company_id)->get();
        $units = $company->units;
        $check = Product::where('company_id', $company_id)->get();
        if ($check->isEmpty()) {
            $code_universal = "100000001";
        } else {
            // $old_order = Product::where('company_id',$company_id)->max('code_universal');
            // $code_universal = ++$old_order;
            $code_universal = time() . substr(time(), 0, 2);
        }
        return view(
            'client.products.create',
            compact('company_id', 'units', 'sub_categories', 'code_universal', 'categories', 'stores', 'company')
        );
    }

    public function store_pos(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();

        $data['company_id'] = Auth::user()->company_id;
        $product = Product::create($data);
        if ($product) {
            return response()->json([
                'status' => true,
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'code_universal' => $product->code_universal,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'هناك خطأ فى تسجيل الدفع النقدى حاول مرة اخرى',
            ]);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
        ]);
        $data = $request->all();
        if (empty($data['first_balance'])) $data['first_balance'] = 0;
        if (empty($data['qr']))
            $company_id = $data['company_id'];


        // check for category if khadamya
        $cat = Category::find($data['category_id']);
        if ($cat->category_type == 'خدمية') $data['first_balance'] = 10000000;

        $product = Product::create($data);
        if ($request->hasFile('product_pic')) {
            $image = $request->file('product_pic');
            $fileName = $image->getClientOriginalName();
            $uploadDir = 'uploads/products/' . $product->id;
            $image->move($uploadDir, $fileName);
            $product->product_pic = $uploadDir . '/' . $fileName;
            $product->save();
        }
        return redirect()->route('client.products.index')
            ->with('success', 'تم اضافة المنتج بنجاح');
    }
    public function show($id)
    {
        $product = Product::FindOrFail($id);
        return view('client.products.show', compact('product'));
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = Store::where('company_id', $company_id)->get();
        $categories = Category::where('company_id', $company_id)->get();
        $sub_categories = SubCategory::where('company_id', $company_id)->get();
        $product = Product::findOrFail($id);
        $units = $company->units;
        return view('client.products.edit', compact('stores', 'sub_categories', 'units', 'categories', 'product', 'company_id', 'company'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'required',
        ]);
        $data = $request->all();

        // check for category if khadamya
        $cat = Category::find($data['category_id']);
        if ($cat->category_type == 'خدمية') $data['first_balance'] = 10000000;

        $data['viewed'] = 0;
        $company_id = $data['company_id'];
        $product = Product::findOrFail($id);
        $product->update($data);
        if ($request->hasFile('product_pic')) {
            $image = $request->file('product_pic');
            $fileName = $image->getClientOriginalName();
            $uploadDir = 'uploads/products/' . $product->id;
            $image->move($uploadDir, $fileName);
            $product->product_pic = $uploadDir . '/' . $fileName;
            $product->save();
        }
        return redirect()->route('client.products.index')
            ->with('success', 'تم تعديل المنتج بنجاح');
    }

    public function destroy(Request $request)
    {
        $product = Product::FindOrFail($request->productid);
        $product->delete();
        return redirect()->route('client.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }
    public function print()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = Product::where('company_id', $company_id)
            ->where('first_balance', '>', 0)
            ->get();
        return view('client.products.print', compact('products', 'company'));
    }
    public function limited()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = Product::where('company_id', $company_id)
            ->where('first_balance', '>', '0')
            ->whereColumn('first_balance', '<', 'min_balance')
            ->get();
        return view('client.products.limited', compact('company', 'company_id', 'products'));
    }
    public function barcode()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = Product::where('company_id', $company_id)
            ->where('code_universal', '!=', '')
            ->get();
        return view('client.products.generate', compact('products'));
    }
    public function generate_barcode(Request $request)
    {
        $count = $request->count;
        $exp_date = $request->exp_date;
        $product = Product::FindOrFail($request->product_id);
        return view('client.products.barcode', compact('product', 'count', 'exp_date'));
    }




    //check if there are products out of stock...
    public function getNumProductsOutOfStock()
    {
        $num = Product::where('company_id', Auth::user()->company_id)
            ->where('first_balance', '<=', 0)
            ->where('viewed', 0)
            ->count();
        return json_encode($num);
    }

    //set products that are out of stock ===> ok i viewed it...
    public function setProductsOutOfStockViewed()
    {
        $products = Product::where('company_id', Auth::user()->company_id)
            ->where('first_balance', '<=', 0)
            ->get();

        foreach ($products as $prod) {
            $prod->viewed = 1;
            $prod->save();
        }
    }
}
