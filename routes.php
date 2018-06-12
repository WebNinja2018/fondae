<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Start For Admin
|--------------------------------------------------------------------------
*/

/* For Add Home */
Route::get('/index','adminarea\Home_controllers@index');
Route::get('/', 'adminarea\Login_controllers@index');
Route::any('adminarea/project_boq/autocomplete_project', 'adminarea\Project_boq_controllers@autocomplete_project');


Route::group(array('prefix' => 'adminarea/home'), function()
{
	Route::resource('/', 'adminarea\Home_controllers@index');
	Route::resource('/setSidemenu', 'adminarea\Home_controllers@setSidemenu');
	Route::resource('/setsearch', 'adminarea\Home_controllers@setsearch');
	Route::resource('/setFontsize', 'adminarea\Home_controllers@setFontsize');
});

/* For Add Login */
Route::group(array('prefix' => 'adminarea'), function()
{
	Route::resource('/', 'adminarea\Login_controllers@index');
	Route::resource('/login', 'adminarea\Login_controllers@index');
	Route::resource('/login_process', 'adminarea\Login_controllers@login_process');
	Route::resource('/logout', 'adminarea\Login_controllers@logout');
	Route::resource('/forgotpassword', 'adminarea\Forgotpassword_controllers@index');
	Route::resource('/forgotpassword_process', 'adminarea\Forgotpassword_controllers@forgotpassword_process');
	Route::resource('/reset-password', 'adminarea\Forgotpassword_controllers@reset_password');
	Route::resource('/resetpassword_process', 'adminarea\Forgotpassword_controllers@resetpassword_process');
});

/* For Add Admin Menu */
Route::group(array('prefix' => 'adminarea/adminmenu'), function()
{
	Route::resource('/', 'adminarea\Adminmenu_controllers@index');
	Route::resource('/index', 'adminarea\Adminmenu_controllers@index');
	Route::resource('/getReorder', 'adminarea\Adminmenu_controllers@getReorder');
	Route::resource('/addeditadminmenu', 'adminarea\Adminmenu_controllers@addeditadminmenu');
	Route::resource('/saveadminmenu', 'adminarea\Adminmenu_controllers@saveadminmenu');
	Route::resource('/singledelete', 'adminarea\Adminmenu_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Adminmenu_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Adminmenu_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Adminmenu_controllers@singlestatus');
});

/* For Add Role */
Route::group(array('prefix' => 'adminarea/role'), function()
{
	Route::resource('/', 'adminarea\Role_controllers@index');
	Route::resource('/index', 'adminarea\Role_controllers@index');
	Route::resource('/getReorder', 'adminarea\Role_controllers@getReorder');
	Route::resource('/addeditrole', 'adminarea\Role_controllers@addeditrole');
	Route::resource('/saverole', 'adminarea\Role_controllers@saverole');
	Route::resource('/singledelete', 'adminarea\Role_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Role_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Role_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Role_controllers@singlestatus');
});

/* For Add User */
Route::group(array('prefix' => 'adminarea/user'), function()
{
	Route::resource('/', 'adminarea\User_controllers@index');
	Route::resource('/index', 'adminarea\User_controllers@index');
	Route::resource('/addedituser', 'adminarea\User_controllers@addedituser');
	Route::resource('/saveuser', 'adminarea\User_controllers@saveuser');
	Route::resource('/singledelete', 'adminarea\User_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\User_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\User_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\User_controllers@singlestatus');
});

/* For Add Pages */
Route::group(array('prefix' => 'adminarea/pages'), function()
{
	Route::resource('/', 'adminarea\Pages_controllers@index');
	Route::resource('/index', 'adminarea\Pages_controllers@index');
	Route::resource('/addeditpages', 'adminarea\Pages_controllers@addeditpages');
	Route::resource('/getChildPages', 'adminarea\Pages_controllers@getChildpages');
	Route::resource('/savepages', 'adminarea\Pages_controllers@savepages');
	Route::resource('/singledelete', 'adminarea\Pages_controllers@singledelete');
	Route::resource('/singlestatus', 'adminarea\Pages_controllers@singlestatus');
	Route::resource('/imagedelete', 'adminarea\Pages_controllers@imagedelete');
});
/* For Add Category */
Route::group(array('prefix' => 'adminarea/category'), function()
{
	Route::resource('/', 'adminarea\Category_controllers@index');
	Route::resource('/index', 'adminarea\Category_controllers@index');
	Route::resource('/getReorder', 'adminarea\Category_controllers@getReorder');
	Route::resource('/addeditcategory', 'adminarea\Category_controllers@addeditcategory');
	Route::resource('/savecategory', 'adminarea\Category_controllers@savecategory');
	Route::resource('/singledelete', 'adminarea\Category_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Category_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Category_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Category_controllers@singlestatus');
	Route::resource('/categoryorder', 'adminarea\Category_controllers@categoryorder');
	Route::resource('/saveorder', 'adminarea\Category_controllers@saveorder');
});

/* For Add Faq */
Route::group(array('prefix' => 'adminarea/company'), function()
{
	Route::resource('/', 'adminarea\Company_controllers@index');
	Route::resource('/index', 'adminarea\Company_controllers@index');
	Route::resource('/addeditcompany', 'adminarea\Company_controllers@addeditcompany');
	Route::resource('/savecompany', 'adminarea\Company_controllers@savecompany');
	Route::resource('/singledelete', 'adminarea\Company_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Company_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Company_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Company_controllers@singlestatus');
});

/* For Add units_of_measurement */
Route::group(array('prefix' => 'adminarea/units_of_measurement'), function()
{
	Route::resource('/', 'adminarea\Units_of_measurement_controllers@index');
	Route::resource('/index', 'adminarea\Units_of_measurement_controllers@index');
	Route::resource('/addeditunits_of_measurement', 'adminarea\Units_of_measurement_controllers@addeditunits_of_measurement');
	Route::resource('/saveunits_of_measurement', 'adminarea\Units_of_measurement_controllers@saveunits_of_measurement');
	Route::resource('/singledelete', 'adminarea\Units_of_measurement_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Units_of_measurement_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Units_of_measurement_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Units_of_measurement_controllers@singlestatus');
});

/* For Add main_items */
Route::group(array('prefix' => 'adminarea/main_items'), function()
{
	Route::resource('/', 'adminarea\Main_items_controllers@index');
	Route::resource('/index', 'adminarea\Main_items_controllers@index');
	Route::resource('/addeditmain_items', 'adminarea\Main_items_controllers@addeditmain_items');
	Route::resource('/savemain_items', 'adminarea\Main_items_controllers@savemain_items');
	Route::resource('/singledelete', 'adminarea\Main_items_controllers@singledelete');
	Route::resource('/multipleDelete', 'adminarea\Main_items_controllers@multipleDelete');
});

/* For Add sub_items */
Route::group(array('prefix' => 'adminarea/sub_items'), function()
{
	Route::resource('/', 'adminarea\Sub_items_controllers@index');
	Route::resource('/index', 'adminarea\Sub_items_controllers@index');
	Route::resource('/addeditsub_items', 'adminarea\Sub_items_controllers@addeditsub_items');
	Route::resource('/savesub_items', 'adminarea\Sub_items_controllers@savesub_items');
	Route::resource('/singledelete', 'adminarea\Sub_items_controllers@singledelete');
	Route::resource('/multipleDelete', 'adminarea\Sub_items_controllers@multipleDelete');
});

/* For Add sub_items */
Route::group(array('prefix' => 'adminarea/project_rate'), function()
{
	Route::resource('/', 'adminarea\Project_rate_controllers@index');
	Route::resource('/index', 'adminarea\Project_rate_controllers@index');
	Route::resource('/addeditproject_rate', 'adminarea\Project_rate_controllers@addeditproject_rate');
	Route::resource('/saveproject_rate', 'adminarea\Project_rate_controllers@saveproject_rate');
	Route::resource('/singledelete', 'adminarea\Project_rate_controllers@singledelete');
	Route::resource('/multipleDelete', 'adminarea\Project_rate_controllers@multipleDelete');
	Route::resource('/getSub_items', 'adminarea\Project_rate_controllers@getSub_items');
	Route::resource('/getUOM', 'adminarea\Project_rate_controllers@getUOM');
});

/* For Add project */
Route::group(array('prefix' => 'adminarea/project'), function()
{
	Route::resource('/', 'adminarea\Project_controllers@index');
	Route::resource('/index', 'adminarea\Project_controllers@index');
	Route::resource('/addeditproject', 'adminarea\Project_controllers@addeditproject');
	Route::resource('/saveproject', 'adminarea\Project_controllers@saveproject');
	Route::resource('/singledelete', 'adminarea\Project_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Project_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Project_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Project_controllers@singlestatus');
	Route::resource('/checkprojectnumber', 'adminarea\Project_controllers@checkprojectnumber');
});

/* For Add Project Details */
Route::group(array('prefix' => 'adminarea/project_details'), function()
{
	Route::resource('/', 'adminarea\Project_details_controllers@index');
	Route::resource('/index', 'adminarea\Project_details_controllers@index');
	Route::resource('/addeditproject_details', 'adminarea\Project_details_controllers@addeditproject_details');
	Route::resource('/saveproject_details', 'adminarea\Project_details_controllers@saveproject_details');
	Route::resource('/getSub_items', 'adminarea\Project_details_controllers@getSub_items');
	Route::resource('/add_project_actuals', 'adminarea\Project_details_controllers@add_project_actuals');
	Route::resource('/add_actuals', 'adminarea\Project_details_controllers@add_actuals');
	Route::resource('/getprojectrate', 'adminarea\Project_details_controllers@getprojectrate');
	Route::resource('/getbalanceQty', 'adminarea\Project_details_controllers@getbalanceQty');
	Route::resource('/add_plan_report', 'adminarea\Project_details_controllers@add_plan_report');
	Route::resource('/add_project_details_manHours', 'adminarea\Project_details_controllers@add_project_details_manHours');
});

/* For Add Project BOQ */
Route::group(array('prefix' => 'adminarea/project_boq'), function()
{
	Route::resource('/', 'adminarea\Project_boq_controllers@index');
	Route::resource('/index', 'adminarea\Project_boq_controllers@index');
	Route::resource('/addeditproject_boq', 'adminarea\Project_boq_controllers@addeditproject_boq');
	Route::resource('/saveproject_boq', 'adminarea\Project_boq_controllers@saveproject_boq');
	Route::resource('/singledelete', 'adminarea\Project_boq_controllers@singledelete');
	Route::resource('/multipleDelete', 'adminarea\Project_boq_controllers@multipleDelete');
	Route::resource('/imagedelete', 'adminarea\Project_boq_controllers@imagedelete');
	Route::resource('/getMain_items', 'adminarea\Project_boq_controllers@getMain_items');
	Route::resource('/import', 'adminarea\Project_boq_controllers@import');
	Route::resource('/saveImport', 'adminarea\Project_boq_controllers@saveImport');
	Route::resource('/getProject', 'adminarea\Project_boq_controllers@getProject');
});


/* For Add Images */
Route::group(array('prefix' => 'adminarea/images'), function()
{
	Route::resource('/saveimages', 'adminarea\Images_controllers@saveimages');
	Route::resource('/singledelete', 'adminarea\Images_controllers@singledelete');
	Route::resource('/singlestatus', 'adminarea\Images_controllers@singlestatus');
	Route::resource('/imagesorder', 'adminarea\Images_controllers@imagesorder');
	Route::resource('/saveorder', 'adminarea\Images_controllers@saveorder');
});

/* For Add File */
Route::group(array('prefix' => 'adminarea/file'), function()
{
	Route::resource('/savefile', 'adminarea\File_controllers@savefile');
	Route::resource('/singledelete', 'adminarea\File_controllers@singledelete');
	Route::resource('/singlestatus', 'adminarea\File_controllers@singlestatus');
	Route::resource('/fileorder', 'adminarea\File_controllers@fileorder');
	Route::resource('/saveorder', 'adminarea\File_controllers@saveorder');
});

/* For Add Report*/
Route::group(array('prefix' => 'adminarea/report'), function()
{
	Route::resource('/project', 'adminarea\Report_controllers@project');
	Route::resource('/contactsingledelete', 'adminarea\Report_controllers@contactsingledelete');
	Route::resource('/emailthispage', 'adminarea\Report_controllers@emailthispage');
	Route::resource('/emailthispagesingledelete', 'adminarea\Report_controllers@emailthispagesingledelete');
	Route::resource('/emailnews', 'adminarea\Report_controllers@emailnews');
	Route::resource('/emailnewssingledelete', 'adminarea\Report_controllers@emailnewssingledelete');
	Route::resource('/formbuilder', 'adminarea\Report_controllers@formbuilder');
	Route::resource('/formbuildersingledelete', 'adminarea\Report_controllers@formbuildersingledelete');
	Route::resource('/emailsetting', 'adminarea\Report_controllers@emailsetting');
	Route::resource('/saveEmailResponder', 'adminarea\Report_controllers@saveEmailResponder');
	Route::resource('/singlestatus', 'adminarea\Report_controllers@singlestatus');
	Route::resource('/singledelete', 'adminarea\Report_controllers@singledelete');
	Route::resource('/checkemail', 'adminarea\Report_controllers@checkemail');
	Route::resource('/getExportContactus', 'adminarea\Report_controllers@getExportContactus');
	Route::resource('/getExportEmailnews', 'adminarea\Report_controllers@getExportEmailnews');
	Route::resource('/getExportEmailthispage', 'adminarea\Report_controllers@getExportEmailthispage');
});

/* For Add Globalsetting */
Route::group(array('prefix' => 'adminarea/globalsetting'), function()
{
	Route::resource('/', 'adminarea\Globalsetting_controllers@index');
	Route::resource('/index', 'adminarea\Globalsetting_controllers@index');
	Route::resource('/addeditglobalsetting', 'adminarea\Globalsetting_controllers@addeditglobalsetting');
	Route::resource('/saveglobalsetting', 'adminarea\Globalsetting_controllers@saveglobalsetting');
	Route::resource('/singledelete', 'adminarea\Globalsetting_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Globalsetting_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Globalsetting_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Globalsetting_controllers@singlestatus');
	Route::resource('/createFile', 'adminarea\Globalsetting_controllers@createFile');
});

/* For Add Common Messages */
Route::group(array('prefix' => 'adminarea/commonmessage'), function()
{
	Route::resource('/', 'adminarea\Commonmessage_controllers@index');
	Route::resource('/index', 'adminarea\Commonmessage_controllers@index');
	Route::resource('/addeditcommonmessage', 'adminarea\Commonmessage_controllers@addeditcommonmessage');
	Route::resource('/savecommonmessage', 'adminarea\Commonmessage_controllers@savecommonmessage');
	Route::resource('/singledelete', 'adminarea\Commonmessage_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Commonmessage_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Commonmessage_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Commonmessage_controllers@singlestatus');
	Route::resource('/createFile', 'adminarea\Commonmessage_controllers@createFile');
});


/* For Add Order */
Route::group(array('prefix' => 'adminarea/changepassword'), function()
{
	Route::resource('/', 'adminarea\Changepassword_controllers@index');
	Route::resource('/change_password', 'adminarea\Changepassword_controllers@change_password');
	Route::resource('/checkpassword', 'adminarea\Changepassword_controllers@checkpassword');
});
/*
/*
|--------------------------------------------------------------------------
| End For Admin
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Start For Front-End
|--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'action'), function()
{
	Route::resource('/enewsletter', 'Action_controllers@enewsletter');
	Route::resource('/unsubscribe', 'Action_controllers@unsubscribe');
	Route::resource('/chackenewsletter', 'Action_controllers@chackenewsletter');
	Route::resource('/contactus', 'Action_controllers@contactus');
	Route::resource('/addtocart', 'Action_controllers@addtocart');
	Route::resource('/checkoutshippingaction', 'Action_controllers@checkoutshippingaction');
	Route::resource('/checkoutbillingaction', 'Action_controllers@checkoutbillingaction');
	Route::resource('/myprofile', 'Action_controllers@myprofile');
	Route::resource('/getPriceTotal', 'Action_controllers@getPriceTotal');
	Route::resource('/customeraddressaddedit', 'Action_controllers@customeraddressaddedit');
	Route::resource('/changepassword', 'Action_controllers@changepassword');
	Route::resource('/forgotpassword', 'Action_controllers@forgotpassword');
	Route::resource('/resetpassword', 'Action_controllers@resetpassword');
	
});

Route::group(array('prefix' => 'payment'), function()
{
	Route::resource('/confirmOrder', 'Payment_controllers@confirmOrder');
	Route::resource('/doExpressCheckout', 'Payment_controllers@doExpressCheckout');
    Route::resource('/completeExpressCheckout', 'Payment_controllers@completeExpressCheckout');
	Route::resource('/doDirectPayment', 'Payment_controllers@doDirectPayment');
	Route::resource('/orderMail', 'Payment_controllers@orderMail');
});

Route::group(array('prefix' => 'signup'), function()
{
	Route::resource('/register', 'Signup_controllers@register');
	Route::resource('/guestcheckout', 'Signup_controllers@guestcheckout');
	Route::resource('/login', 'Signup_controllers@login');
	Route::resource('/logout', 'Signup_controllers@logout');
	Route::resource('/ajaxCheckCustomerEmailExist', 'Signup_controllers@ajaxCheckCustomerEmailExist');
});

Route::group(array('prefix' => 'ajax'), function()
{
	Route::resource('/getPriceTotal', 'Ajax_controllers@getPriceTotal');
	Route::resource('/updateCartQuantity', 'Ajax_controllers@updateCartQuantity');
	Route::resource('/deleteCartProduct', 'Ajax_controllers@deleteCartProduct');
	Route::resource('/deleteCart', 'Ajax_controllers@deleteCart');
	Route::resource('/getallstate', 'Ajax_controllers@getallstate');
	Route::resource('/getAddressData', 'Ajax_controllers@getAddressData');
});

Route::get('/customeraddressaddedit', 'Pages_controllers@customeraddressaddedit');

Route::get('/{filename?}', 'Pages_controllers@index');
Route::post('/{filename?}', 'Pages_controllers@index');
Route::resource('/{filename?}/{urlName?}', 'Pages_controllers@index');

/*
|--------------------------------------------------------------------------
| End For Front-End
|--------------------------------------------------------------------------
*/