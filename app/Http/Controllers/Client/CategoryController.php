<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $categories = $company->categories;
        return view('client.categories.index', compact('company', 'company_id', 'categories'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.categories.create', compact('company_id', 'company'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required',
            'category_type' => 'required',
        ]);
        $data = $request->all();
        $company_id = $data['company_id'];
        $category = Category::create($data);
        return redirect()->route('client.categories.index')
            ->with('success', 'تم اضافة الفئة بنجاح');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $category = Category::findOrFail($id);
        return view('client.categories.edit', compact('category', 'company_id', 'company'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_name' => 'required',
            'category_type' => 'required',
        ]);
        $input = $request->all();
        $category = Category::findOrFail($id);
        $category->update($input);
        return redirect()->route('client.categories.index')
            ->with('success', 'تم تعديل بيانات الفئة بنجاح');
    }

    public function destroy(Request $request)
    {
        Category::findOrFail($request->categoryid)->delete();
        return redirect()->route('client.categories.index')
            ->with('success', 'تم حذف الفئة بنجاح');
    }
}
