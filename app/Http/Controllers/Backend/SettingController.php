<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmtpSetting;

class SettingController extends Controller
{
    public function SmtpSetting()
    {
      $setting = SmtpSetting::find(1);

      return view('backend.setting.smtp_update', compact('setting'));
    }
    public function UpdateSmtpSetting(Request $request)
    {
      // recup de l'id depuis le template
        $smtp_id = $request->id;

        SmtpSetting::findOrFail($smtp_id)->update([
            'mailer' => $request->mailer,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'encryption' => $request->encryption,
            'from_address' => $request->from_address,
        ]);


         $notification = array(
           'message' => 'Smtp Setting Updated Successfully',
           'alert-type' => 'success'
        );

       return redirect()->back()->with($notification);
    }
}
