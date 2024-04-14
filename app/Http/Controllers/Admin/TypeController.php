<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::all();
        return view('admin.types.index', compact('types'));
    }
    public function create()
    {
        $packages = Package::all();
        return view('admin.types.create',compact('packages'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type_name' => 'required',
            'type_price' => 'required',
            'period' => 'required',
            'package_id' => 'required'
        ]);
        $data = $request->all();
        $type = Type::create($data);
        return redirect()->route('admin.types.index')
            ->with('success', 'تم اضافة نوع الاشتراك وسعره بنجاح');
    }

    public function edit($id)
    {
        $type = Type::findOrFail($id);
        $packages = Package::all();
        return view('admin.types.edit', compact('type','packages'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type_name' => 'required',
            'type_price' => 'required',
            'period' => 'required',
            'package_id' => 'required',
        ]);
        $input = $request->all();
        $type = Type::findOrFail($id);
        $type->update($input);
        return redirect()->route('admin.types.index')
            ->with('success', 'تم تعديل بيانات نوع الاشتراك بنجاح');
    }
    public function destroy(Request $request)
    {
        $type = Type::findOrFail($request->typeid);
        $type->delete();
        return redirect()->route('admin.types.index')
            ->with('success', 'تم حذف نوع الاشتراك بنجاح');
    }


}
