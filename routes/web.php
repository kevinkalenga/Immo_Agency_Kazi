<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Agent\AgentPropertyController;

use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CompareController;

// Route::get('/', function () {
//     return view('welcome');
// });

// User Frontend All Route 
Route::get('/', [UserController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// auth middleware par defaut pour l'authentification de user
Route::middleware('auth')->group(function () {
     Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
     Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
     Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
     Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
     Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');

     // User Wishlist All Route
    Route::controller(WishlistController::class)->group(function(){
         Route::get('/user/wishlist', 'UserWishlist')->name('user.wishlist');
         Route::get('/get-wishlist-property', 'GetWishlistProperty');
         Route::post('/wishlist-remove/{id}', 'WishlistRemove');  
        
    });
     // User Comparelist All Route
    Route::controller(CompareController::class)->group(function(){
         Route::get('/user/compare', 'UserCompare')->name('user.compare');
         Route::get('/get-compare-property', 'GetCompareProperty');
        
    });
});

require __DIR__.'/auth.php';

// Admin(auth to verify if is logged in)

 Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
 });
// Admin(auth to verify if is logged in)

Route::middleware(['auth', 'role:admin'])->group(function(){
    
   // Property Type All Route
    Route::controller(PropertyTypeController::class)->group(function(){
         Route::get('/all/type', 'AllType')->name('all.type');
         Route::get('/add/type', 'AddType')->name('add.type');
         Route::post('/store/type', 'StoreType')->name('store.type');
         Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
         Route::post('/update/type/{id}', 'UpdateType')->name('update.type');
         Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');
    });
   // Amenities Type All Route
    Route::controller(PropertyTypeController::class)->group(function(){
         Route::get('/all/amenitie', 'AllAmenitie')->name('all.amenitie');
         Route::get('/add/amenitie', 'AddAmenitie')->name('add.amenitie');
         Route::post('/store/amenitie', 'StoreAmenitie')->name('store.amenitie');
         Route::get('/edit/amenitie/{id}', 'EditAmenitie')->name('edit.amenitie');
         Route::post('/update/amenitie/{id}', 'UpdateAmenitie')->name('update.amenitie');
         Route::get('/delete/amenitie/{id}', 'DeleteAmenitie')->name('delete.amenitie');
    });
   // Property All Route
    Route::controller(PropertyController::class)->group(function(){
         Route::get('/all/propertie', 'AllPropertie')->name('all.propertie');
         Route::get('/add/propertie', 'AddPropertie')->name('add.propertie');
         Route::post('/store/propertie', 'StorePropertie')->name('store.propertie');
         Route::get('/edit/propertie/{id}', 'EditPropertie')->name('edit.propertie');
         Route::get('/delete/propertie/{id}', 'DeletePropertie')->name('delete.propertie');
         Route::post('/update/propertie/{id}', 'UpdatePropertie')->name('update.propertie');
         Route::post('/update/propertie/thambnail/{id}', 'UpdatePropertieThambnail')->name('update.propertie.thambnail');
         Route::post('/update/propertie/multiimage/{id}', 'UpdatePropertieMultiimage')->name('update.propertie.multiimage');
         Route::get('/delete/propertie/multiimage/{id}', 'DeletePropertieMultiimage')->name('delete.propertie.multiimg');
         Route::post('/store/new/multiimage', 'StoreNewMultiimage')->name('store.new.multiimage');
         Route::post('/update/property/facilities', 'UpdatePropertyFacilities')->name('update.propertie.facilities');
         Route::get('/details/property/{id}', 'DetailsProperty')->name('details.propertie');
         Route::post('/inactive/property', 'InactiveProperty')->name('inactive.property');
         Route::post('/active/property', 'ActiveProperty')->name('active.property');
         Route::get('/admin/package/history', 'AdminPackageHistory')->name('admin.package.history');
         Route::get('/package/invoice/{id}', 'PackageInvoice')->name('package.invoice');
        
       
    });


     // Agent All Route from admin
     Route::controller(AdminController::class)->group(function(){
         Route::get('/all/agent', 'AllAgent')->name('all.agent');
         Route::get('/add/agent', 'AddAgent')->name('add.agent');
         Route::post('/store/agent', 'StoreAgent')->name('store.agent'); 
         Route::get('/edit/agent/{id}', 'EditAgent')->name('edit.agent'); 
         Route::post('/update/agent', 'UpdateAgent')->name('update.agent');
         Route::get('/delete/agent/{id}', 'DeleteAgent')->name('delete.agent'); 
         Route::get('/changeStatus', 'changeStatus');
        
    });
});


 Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware('guest');  // ← empêche un admin déjà connecté de revenir sur login





// Agent 
 Route::middleware(['auth', 'role:agent'])->group(function(){
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard'); 
    Route::get('/agent/logout', [AgentController::class, 'AgentLogout'])->name('agent.logout');
    Route::get('/agent/profile', [AgentController::class, 'AgentProfile'])->name('agent.profile');
    Route::post('/agent/profile/store', [AgentController::class, 'AgentProfileStore'])->name('agent.profile.store');
    Route::get('/agent/change/password', [AgentController::class, 'AgentChangePassword'])->name('agent.change.password');
    Route::post('/agent/password/update', [AgentController::class, 'AgentPasswordUpdate'])->name('agent.password.update');
   

 });

 Route::get('/agent/login', [AgentController::class, 'AgentLogin'])
     ->name('agent.login')
     ->middleware('guest'); // empêche un agent déjà connecté de revenir sur login
 Route::post('/agent/register', [AgentController::class, 'AgentRegister'])->name('agent.register'); 

 Route::middleware(['auth', 'role:agent'])->group(function(){
        //  Agent All Property   
         Route::controller(AgentPropertyController::class)->group(function(){
           Route::get('agent/all/propertie', 'AgentAllPropertie')->name('agent.all.propertie');
           Route::get('/agent/add/propertie', 'AgentAddPropertie')->name('agent.add.propertie'); 
           Route::post('/agent/store/propertie', 'AgentStorePropertie')->name('agent.store.propertie'); 
           Route::get('/agent/edit/propertie/{id}', 'AgentEditPropertie')->name('agent.edit.propertie'); 
           Route::post('/agent/update/propertie/{id}', 'AgentUpdatePropertie')->name('agent.update.propertie'); 
           Route::post('/agent/update/property/thambnail', 'AgentUpdatePropertieThambnail')->name('agent.update.propertie.thambnail'); 
           Route::post('/agent/update/property/multiimage', 'AgentUpdatePropertieMultiimage')->name('agent.update.propertie.multiimage'); 
           Route::get('/agent/property/multiimg/delete/{id}', 'AgentPropertieMultiimgDelete')->name('agent.propertie.multiimg.delete'); 
           Route::post('/agent/store/new/multiimage', 'AgentStoreNewMultiimage')->name('agent.store.new.multiimage'); 
           Route::post('/agent/update/propertie/facilities', 'AgentUpdatePropertieFacilities')->name('agent.update.propertie.facilities'); 
           Route::get('/agent/details/propertie/{id}', 'AgentDetailsProperty')->name('agent.details.propertie');
           Route::get('/agent/delete/propertie/{id}', 'AgentDeletePropertie')->name('agent.delete.propertie'); 

          
   
         
        });
         //   Agent Buy Package  
         Route::controller(AgentPropertyController::class)->group(function(){
             Route::get('/buy/package', 'BuyPackage')->name('buy.package');
             Route::get('/buy/business/plan', 'BuyBusinessPlan')->name('buy.business.plan');
             Route::post('/store/business/plan', 'StoreBusinessPlan')->name('store.business.plan');
             Route::get('/buy/professional/plan', 'BuyProfessionalPlan')->name('buy.professional.plan');
             Route::post('/store/professional/plan', 'StoreProfessionalPlan')->name('store.professional.plan');
             Route::get('/package/history', 'PackageHistory')->name('package.history');
             Route::get('/agent/package/invoice/{id}', 'AgentPackageInvoice')->name('agent.package.invoice');
        });
 });


//  Frontend Property Details All Route 

Route::get('/property/details/{id}/{slug}', [IndexController::class, 'PropertyDetails']);
Route::post('/add-to-wishlist/{property_id}', [WishlistController::class, 'AddToWishlist']);
Route::post('/add-to-compare/{property_id}', [CompareController::class, 'AddToCompare']);



