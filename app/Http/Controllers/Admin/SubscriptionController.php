<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Type;
use DateTime;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::all();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }
//
    public function edit($id)
    {
        $subscription = Subscription::FindOrFail($id);
        $types = Type::all();
        return view('admin.subscriptions.edit', compact('subscription','types'));
    }
//
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'company_id' => 'required',
            'type_id' => 'required',
            'start_date' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $subscription = Subscription::findOrFail($id);
        $type_id = $request->type_id;
        $type = Type::FindOrFail($type_id);
        $period = $type->period;
        $start_date = $request->start_date;
        $start_date = new DateTime($start_date);
        $start_date->modify( "+ $period day");
        $end_date = $start_date->format('Y-m-d');
        $input['end_date'] = $end_date;
        $subscription->update($input);
        $subscription->company->update([
           'status' => 'active'
        ]);
        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'تم تعديل بيانات الاشتراك بنجاح');
    }
    public function get_filter(){
        $types = Type::all();
        return view('admin.subscriptions.filter',compact('types'));
    }
    public function post_filter(Request $request){
        $types = Type::all();
        $type_id = $request->type_id;
        $subscriptions = Subscription::where('type_id',$type_id)->get();
        return view('admin.subscriptions.filter',compact('types','subscriptions'));
    }

}
