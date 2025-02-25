<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\BranchNameController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessInfoController;
use App\Http\Controllers\DiagramController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DamagedProductController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LastBills;
use App\Http\Controllers\PayPurchaseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubBrandController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TypeStoreController;
use App\Http\Controllers\UserController;
use App\Models\Business;
use App\Models\CompanySetting;
use App\Models\Customer;
use App\Models\ReturnedBill;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('auth.login');

});



Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('brand',BrandController::class);
 Route::resource('sub_brand',SubBrandController::class);
 Route::resource('category',CategoryController::class);
 Route::resource('sub_category',SubCategoryController::class);
 Route::resource('product',ProductController::class);
 Route::resource('bill',BillController::class);
  Route::resource('lastbill',LastBills::class);
 Route::resource('customer',CustomerController::class);
 Route::resource('supplier',SupplierController::class);
 Route::resource('purchase',PurchaseController::class);
 Route::resource('returnbill',ReturnedBill::class);
 Route::resource('expense',ExpenseController::class);
 Route::resource('branchName',BranchNameController::class);
 Route::patch('/expense/{id}', [ExpenseController::class, 'update'])->name('expenseupdate');
 Route::get('/paypurchasebillshow/{id}',[PayPurchaseController::class,'show'])->name('show');
 Route::post('/paypurchasebill/{id}', [PayPurchaseController::class, 'store'])->name('store');
 Route::patch('/paypurchasebill/{id}', [PayPurchaseController::class, 'update'])->name('update');
 Route::resource('store',TypeStoreController::class);
 route::get('diagram',DiagramController::class);
 route::get('diagramdialy',[DiagramController::class,'dailysales'])->name('diagramdialy');
 route::get('hourlySales',[DiagramController::class,'hourlySales'])->name('hourlySales');
 route::get('MontlySales',[DiagramController::class,'MontlySales'])->name('MontlySales');
 route::get('hourlySalesalltime',[DiagramController::class,'hourlySalesalltime'])->name('hourlySalesalltime');


 Route::resource('subscrpition',SubscriptionController::class)->middleware('check.subscription');;
 Route::resource('businesssettings',BusinessInfoController::class);
 Route::get('/products/damaged', [DamagedProductController::class, 'createDamagedProduct'])->name('damaged');
 Route::post('/product/damage', [DamagedProductController::class, 'recordDamagedProduct'])->name('product.damage');
 Route::get('productdamaged', [DamagedProductController::class, 'indexDamagedProduct'])->name('damagedProduct');
 Route::post('transfer-product', [DamagedProductController::class, 'transferProductToBranch'])->name('transfer-product');
 route::get('transfertobranch',[DamagedProductController::class,'transfertobranch'])->name('transfertobranch');

 Route::post('transfer-back-to-store', [DamagedProductController::class, 'transferProductBackToStore'])->name('transfer-back-to-store');
 route::get('transfertostore/{id}',[DamagedProductController::class,'transfertostore'])->name('transfertostore');








 Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);


});
