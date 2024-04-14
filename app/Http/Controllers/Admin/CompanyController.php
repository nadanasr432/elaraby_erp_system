<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
   public function index(){
       $companies = Company::all();
       return view('admin.companies.index',compact('companies'));
   }
    public function edit($id){
        $company = Company::FindOrFail($id);
        return view('admin.companies.edit',compact('company'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $company = Company::findOrFail($id);
        $company->update($input);
        return redirect()->route('admin.companies.index')
            ->with('success', 'تم تعديل بيانات الشركة بنجاح');
    }

    public function destroy(Request $request)
    {
        $company = Company::findOrFail($request->companyid);
        $company->delete();
        return redirect()->route('admin.companies.index')
            ->with('success', 'تم حذف الشركة بنجاح');
    }

}
