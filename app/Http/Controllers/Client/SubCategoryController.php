<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $sub_categories = $company->subCategories;
        return view('client.sub_categories.index', compact('company', 'company_id', 'sub_categories'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $categories = $company->categories;
        return view('client.sub_categories.create', compact('company_id', 'company','categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'sub_category_name' => 'required',
            'category_id' => 'required',
        ]);
        $data = $request->all();
        $company_id = $data['company_id'];
        $sub_category = SubCategory::create($data);
        return redirect()->route('client.subcategories.index')
            ->with('success', 'تم اضافة الفئة الفرعية بنجاح');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $sub_category = SubCategory::findOrFail($id);
        $categories = $company->categories;
        return view('client.sub_categories.edit', compact('sub_category','categories', 'company_id', 'company'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'sub_category_name' => 'required',
            'category_id' => 'required',
        ]);
        $input = $request->all();
        $sub_category = SubCategory::findOrFail($id);
        $sub_category->update($input);
        return redirect()->route('client.subcategories.index')
            ->with('success', 'تم تعديل بيانات الفئة الفرعية بنجاح');
    }

    public function destroy(Request $request)
    {
        SubCategory::findOrFail($request->categoryid)->delete();
        return redirect()->route('client.subcategories.index')
            ->with('success', 'تم حذف الفئة الفرعية بنجاح');
    }
}
