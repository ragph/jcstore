<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('branchlist', 'API\BranchController@branchList');
    Route::post('searchbranch', 'API\BranchController@searchBranch');
    // BOXES
    Route::post('searchbox', 'API\BoxesController@searchBox');

    // BOX MANAGEMENT
    Route::get('loadboxlist', 'API\BoxManagementController@loadBoxlist');

    // PRODUCTS
    Route::post('searchproduct','API\ProductController@searchProduct');
    Route::get('productlist','API\ProductController@productList');

    // INVENTORY
    Route::post('searchinventory','API\InventoryController@searchInventory');
    Route::post('searchtransaction','API\InventoryController@searchTransaction');
    // BOX MANAGEMENT
    Route::apiResources(['boxmanagement' => 'API\BoxManagementController']);
    Route::post('searchboxmanagement', 'API\BoxManagementController@searchBoxManagement');
    Route::get('loadboxlistselect', 'API\BoxManagementController@loadBoxManagement');

    // RETURN PRODUCT
    Route::post('searchreturnprod','API\ReturnProductController@searchReturnProduct');

    // POINT OF SALE
    Route::post('searchproducts','API\PointOfSaleController@searchProducts');
    Route::post('barcodesearch','API\PointOfSaleController@barcodeSearch');
    Route::post('saleprice','API\PointOfSaleController@salePrice');
    Route::apiResources(['pointofsale' => 'API\PointOfSaleController']);

    //SALE HISTORY


    // RETURN SALE
    Route::post('searchreturn','API\ReturnSalesController@searchReturnsales');
    Route::apiResources(['returnsale' => 'API\ReturnSalesController']);
    Route::get('saleslist','API\ReturnSalesController@salesList');

    // RENT
    Route::post('searchduedate','API\RentController@searchDueDate');
    // BRANCH
Route::apiResources(['branch' => 'API\BranchController']);

// RENTER
Route::apiResources(['renter' => 'API\RenterController']);
Route::post('searchrenter', 'API\RenterController@searchRenter');
Route::post('searchrenterforfilter', 'API\RenterController@searchRenterForFilter');
Route::get('renterlist','API\RenterController@renterList');

// BOXES
Route::apiResources(['boxes' => 'API\BoxesController']);
Route::get('boxlist', 'API\BoxesController@boxList');


// CATEGORY
Route::apiResources(['category' => 'API\CategoryController']);
Route::post('searchcategory', 'API\CategoryController@searchCategory');
Route::get('categorylist', 'API\CategoryController@categoryList');
// RENT
Route::apiResources(['rent' => 'API\RentController']);
Route::post('createduedate','API\RentController@createDueDate');

Route::post('monthcoveredlist','API\RentController@monthCoveredList');
Route::post('monthcollectedlist','API\RentController@monthCollectedList');

Route::post('searchpaiddate','API\RentController@searchPaidDate');
Route::post('searchallrent','API\RentController@searchAllRent');
Route::post('paymentrentamount','API\RentController@paymentRentAmount');
// PRODUCT
Route::apiResources(['product' => 'API\ProductController']);


Route::post('selectDelete','API\ProductController@selectPrdctDelte');
Route::get('selectproductID','API\ProductController@selectID');
Route::get('renterslist','API\ProductController@rentersList');
Route::get('totalproducts','API\ProductController@countallProducts');
Route::get('listproducts','API\ProductController@Listofproducts');
// DASHBOARD
Route::get('dashboard','API\DashboardController@dashBoard');
Route::get('dashboardcollection','API\DashboardController@dashboardCollection');

// INVENTORY
Route::apiResources(['inventory' => 'API\InventoryController']);
Route::post('selectIvtry','API\InventoryController@selectIvtryDelte');

// RETURN PRODUCT
Route::apiResources(['return' => 'API\ReturnProductController']);
Route::post('selectreturnproduct','API\ReturnProductController@selectRrnPrdctDelte');


// USER MANAGEMENT
Route::apiResources(['user' => 'API\UserController']);
Route::post('searchuser','API\UserController@searchUser');
Route::post('selectUser','API\UserController@selectUsersDelte');


// RETURN SALES
Route::post('productlist','API\ReturnSalesController@productList');


//SALE HISTORY
Route::apiResources(['salehistory' => 'API\SaleshistoryController']);
Route::post('selectSaleHs','API\SaleshistoryController@selectSaleHsDelte');

// RENTER VIEW API

Route::post('renterproducts','API\RenterViewController@renterProducts');
Route::post('renterinventory','API\RenterViewController@renterInventory');
Route::post('renterreturns','API\RenterViewController@renterProductReturns');
Route::post('rentersaleshistory','API\RenterViewController@renterSalesHistory');
Route::post('renterboxes','API\RenterViewController@renterBoxes');

Route::post('renterdashboarddaily','API\RenterViewController@renterDashboardDAILY');
Route::post('renterdashboardmonth','API\RenterViewController@renterDashboardMONTH');
Route::post('renterdashboardweek','API\RenterViewController@renterDashboardWEEK');
Route::post('lasttransaction','API\RenterViewController@lasttransaction');

//PRINT FILES


// PHP INFO
Route::get('phpinfo','API\BoxesController@phpInfo');

//VOUCHER
Route::apiResources(['voucher' => 'API\VoucherController']);
Route::post('searchvoucher','API\VoucherController@searchVoucher');
// Settings
Route::apiResources(['settings' => 'API\SettingsController']);
Route::get('getsettings','API\SettingsController@settingsFunc');
Route::get('loadbackup', 'API\SettingsController@loadBackup');
Route::get('backup', 'API\SettingsController@download');
Route::post('downloadsql', 'API\SettingsController@downloadSql');
// report api
Route::post('reportrenters','API\ReportController@reportrenterList');
Route::post('reportproducts','API\ReportController@reportproductlist');
Route::post('reportinventory','API\ReportController@reportinventoryList');



Route::post('cubesummary','API\ReportController@reportcubeSummary');
Route::post('renterrentmanager','API\RenterViewController@renterRentManager');
Route::post('renterrentmanagerduedate','API\RenterViewController@DuesRenterManager');
Route::post('reportdirectsales','API\ReportController@reportdirectsales');
Route::post('reportsalesreleased','API\ReportController@reportSalesrel');
Route::post('returnsalesreport','API\ReportController@returnSalesReport');

Route::post('searchsalehistory','API\SaleshistoryController@searchSalehistory');
Route::post('searchsalehistorydirect','API\SaleshistoryController@searchSalehistoryDirect');
Route::get('branchassign','API\SaleshistoryController@branchAssign');
Route::get('boxlistlocation', 'API\BoxesController@boxListLocation');
Route::post('reportinventoryhistory','API\ReportController@inventoryhistory');
Route::post('renterprofile','API\RenterViewController@renterProfile');

Route::apiResources(['producttransmittal' => 'API\ProductTransmittalController']);
Route::post('searchproducttransmittal','API\ProductTransmittalController@searchProductTransmittal');
Route::post('previoussupplier','API\ProductTransmittalController@previousSupplier');
Route::post('deleteselectrans','API\ProductTransmittalController@deleteSelectedTrans');

Route::apiResources(['salescollection' => 'API\SalescollectionController']);
Route::post('searchcollection','API\SalescollectionController@searchCollection');
Route::post('selectcoll','API\SalescollectionController@selectColl');

// System Log
Route::post('systemlogs','API\SystemLogController@searchSystemLog');

// Void Sales
Route::post('voidsalehistory','API\VoidInvoice@SaleHistoryVoid');
Route::post('searchvoidhistory','API\VoidInvoice@searchVoidHistory');
Route::post('voidsalesreport','API\VoidInvoice@voidSalesReports');

});

Route::post('reportsaleshistory','API\ReportController@reportsaleshistory');

//Printfile
Route::get('printfile','API\PrinterController@printFile');