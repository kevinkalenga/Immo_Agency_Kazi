<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;

class RoleController extends Controller
{
    public function AllPermission(){
        $permissions = Permission::latest()->get();
        return view('backend.pages.permission.all_permission',compact('permissions'));
    }

    public function AddPermission(){

        return view('backend.pages.permission.add_permission');

    }

    public function StorePermission(Request $request){

        $permission = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

          $notification = array(
            'message' => 'Permission Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);

    }

    public function EditPermission($id) {
         $permission = Permission::findOrFail($id);
         return view('backend.pages.permission.edit_permission', compact('permission'));
    }

    public function UpdatePermission(Request $request){
       // hidden id coming from the form   
       $per_id = $request->id;

         Permission::findOrFail($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

          $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);

    }

    public function DeletePermission($id){
      Permission::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
    
    public function ImportPermission(){
      return view('backend.pages.permission.import_permission');
    }
    
    public function Export(){
      return Excel::download(new PermissionExport, 'permission.xlsx');
    }

    public function Import(Request $request){

        Excel::import(new PermissionImport, $request->file('import_file'));
       
        $notification = array(
            'message' => 'Permission Imported Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }


    
    /////////// All Roles Method //////////////////////

    public function AllRoles(){

        $roles = Role::latest()->get();
        return view('backend.pages.roles.all_roles',compact('roles'));

    }

    public function AddRoles(){
        return view('backend.pages.roles.add_roles');
    }

    public function StoreRoles(Request $request){
        
        Role::create([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Role Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);  

    }

    public function EditRoles($id){

        $roles = Role::find($id);
        return view('backend.pages.roles.edit_roles',compact('roles'));

    }

    public function UpdateRoles(Request $request){
        // id coming from the hidden input
        $role_id = $request->id;

        Role::find($role_id)->update([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);   

    }

    public function DeleteRoles($id){

        Role::find($id)->delete();

        $notification = array(
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);   

    }
}
