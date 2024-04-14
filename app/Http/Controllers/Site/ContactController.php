<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send_message(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' =>
                array(
                    'required',
                    'regex:/(01)[0|1|2|5][0-9]{8}/'
                ),
            'subject' => 'required',
            'message' => 'required'
        ]);
        Contact::create($request->all());
        return redirect()->back()->with('success','تم ارسال رسالتك الى الادارة');
    }
}
