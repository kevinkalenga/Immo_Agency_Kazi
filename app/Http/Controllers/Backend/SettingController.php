<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmtpSetting;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

    public function SiteSetting()
    {
      $siteSetting = SiteSetting::find(1);

      return view('backend.setting.site_update', compact('siteSetting'));
    }


  public function UpdateSiteSetting(Request $request)
  {
      $site = SiteSetting::findOrFail($request->id);

      $request->validate([
          'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
      ]);

      if ($request->hasFile('logo')) {

          // Supprimer l'ancien logo
          if ($site->logo && File::exists(public_path($site->logo))) {
              File::delete(public_path($site->logo));
          }

          // Redimensionner et enregistrer le nouveau logo
          $manager = new ImageManager(new Driver());

          $image = $manager->read($request->file('logo'))
              ->resize(1500, 386);

          $filename = hexdec(uniqid()) . '.' . $request->file('logo')->getClientOriginalExtension();

          $path = public_path('uploads/logo/');

          if (!file_exists($path)) {
              mkdir($path, 0777, true);
          }

          $image->save($path . $filename);

          $save_url = 'uploads/logo/' . $filename;

           // Mettre à jour les autres champs
            $site->update([
                'company_phone' => $request->company_phone,
                'company_address' => $request->company_address,
                'email' => $request->email,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'copyright' => $request->copyright,
                'logo' => $save_url,
            ]);

              $message = 'Site Setting With Image Updated Successfully';
            
      } else {
            $site->update([
                'company_phone' => $request->company_phone,
                'company_address' => $request->company_address,
                'email' => $request->email,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'copyright' => $request->copyright,
            ]);

              $message = 'Site Setting Updated Successfully';
      }

       return redirect()->back()->with([
        'message' => $message,
        'alert-type' => 'success',
      ]);

    
  }
}
