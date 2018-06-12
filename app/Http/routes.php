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

Route::get('emailtesting','ForgotPasswordController@emailtesting');

Route::get('/fondae-login', 'Pages_controllers@admin');


Route::get('password-reset/{token}','ForgotPasswordController@passwordForm')->name('password.open.form');
Route::post('password-reset/{token}','ForgotPasswordController@passwordFormPost')->name('reset.password');

Route::post('/contactsubmit','Pages_controllers@contactsubmit');


/* For Add Home */
Route::get('/index','adminarea\Home_controllers@index');

Route::group(array('prefix' => 'adminarea/home'), function()
{
	Route::resource('/', 'adminarea\Home_controllers@index');
	Route::resource('/setSidemenu', 'adminarea\Home_controllers@setSidemenu');
	Route::resource('/setsearch', 'adminarea\Home_controllers@setsearch');
	Route::resource('/setFontsize', 'adminarea\Home_controllers@setFontsize');
});

/*email verification*/
Route::get('/activate/token/{token}','ActivationController@activate')->name('auth.activate');

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

/* For Add User */
Route::group(array('prefix' => 'adminarea/customer'), function()
{
	Route::resource('/', 'adminarea\Customer_controllers@index');
	Route::resource('/index', 'adminarea\Customer_controllers@index');
	Route::resource('/addeditcustomer', 'adminarea\Customer_controllers@addeditcustomer');
	Route::resource('/savecustomer', 'adminarea\Customer_controllers@savecustomer');
	Route::resource('/singledelete', 'adminarea\Customer_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Customer_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Customer_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Customer_controllers@singlestatus');
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
Route::group(array('prefix' => 'adminarea/faq'), function()
{
	Route::resource('/', 'adminarea\Faq_controllers@index');
	Route::resource('/index', 'adminarea\Faq_controllers@index');
	Route::resource('/getReorder', 'adminarea\Faq_controllers@getReorder');
	Route::resource('/addeditfaq', 'adminarea\Faq_controllers@addeditfaq');
	Route::resource('/savefaq', 'adminarea\Faq_controllers@savefaq');
	Route::resource('/singledelete', 'adminarea\Faq_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Faq_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Faq_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Faq_controllers@singlestatus');
	Route::resource('/faqcategory', 'adminarea\Faq_controllers@faqcategory');
	Route::resource('/addeditfaqcategory', 'adminarea\Faq_controllers@addeditfaqcategory');
	Route::resource('/faqorder', 'adminarea\Faq_controllers@faqorder');
	Route::resource('/saveorder', 'adminarea\Faq_controllers@saveorder');
});

/* For Add Links */
Route::group(array('prefix' => 'adminarea/links'), function()
{
	Route::resource('/', 'adminarea\Links_controllers@index');
	Route::resource('/index', 'adminarea\Links_controllers@index');
	Route::resource('/getReorder', 'adminarea\Links_controllers@getReorder');
	Route::resource('/addeditlinks', 'adminarea\Links_controllers@addeditlinks');
	Route::resource('/savelinks', 'adminarea\Links_controllers@savelinks');
	Route::resource('/singledelete', 'adminarea\Links_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Links_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Links_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Links_controllers@singlestatus');
	Route::resource('/imagedelete', 'adminarea\Links_controllers@imagedelete');
	Route::resource('/linkscategory', 'adminarea\Links_controllers@linkscategory');
	Route::resource('/addeditlinkscategory', 'adminarea\Links_controllers@addeditlinkscategory');
	Route::resource('/linksorder', 'adminarea\Links_controllers@linksorder');
	Route::resource('/saveorder', 'adminarea\Links_controllers@saveorder');
});

/* For Add Slideshow */
Route::group(array('prefix' => 'adminarea/slideshow'), function()
{
	Route::resource('/', 'adminarea\Slideshow_controllers@index');
	Route::resource('/index', 'adminarea\Slideshow_controllers@index');
	Route::resource('/getReorder', 'adminarea\Slideshow_controllers@getReorder');
	Route::resource('/addeditslideshow', 'adminarea\Slideshow_controllers@addeditslideshow');
	Route::resource('/saveslideshow', 'adminarea\Slideshow_controllers@saveslideshow');
	Route::resource('/singledelete', 'adminarea\Slideshow_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Slideshow_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Slideshow_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Slideshow_controllers@singlestatus');
	Route::resource('/imagedelete', 'adminarea\Slideshow_controllers@imagedelete');
	Route::resource('/slideshoworder', 'adminarea\Slideshow_controllers@slideshoworder');
	Route::resource('/saveorder', 'adminarea\Slideshow_controllers@saveorder');
});

/* For Add Gallery */
Route::group(array('prefix' => 'adminarea/gallery'), function()
{
	Route::resource('/', 'adminarea\Gallery_controllers@index');
	Route::resource('/index', 'adminarea\Gallery_controllers@index');
	Route::resource('/getReorder', 'adminarea\Gallery_controllers@getReorder');
	Route::resource('/addeditgallery', 'adminarea\Gallery_controllers@addeditgallery');
	Route::resource('/savegallery', 'adminarea\Gallery_controllers@savegallery');
	Route::resource('/singledelete', 'adminarea\Gallery_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Gallery_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Gallery_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Gallery_controllers@singlestatus');
	Route::resource('/imagedelete', 'adminarea\Gallery_controllers@imagedelete');
	Route::resource('/galleryorder', 'adminarea\Gallery_controllers@galleryorder');
	Route::resource('/saveorder', 'adminarea\Gallery_controllers@saveorder');
});

/* For Add News */
Route::group(array('prefix' => 'adminarea/news'), function()
{
	Route::resource('/', 'adminarea\News_controllers@index');
	Route::resource('/index', 'adminarea\News_controllers@index');
	Route::resource('/getReorder', 'adminarea\News_controllers@getReorder');
	Route::resource('/addeditnews', 'adminarea\News_controllers@addeditnews');
	Route::resource('/savenews', 'adminarea\News_controllers@savenews');
	Route::resource('/singledelete', 'adminarea\News_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\News_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\News_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\News_controllers@singlestatus');
	Route::resource('/imagedelete', 'adminarea\News_controllers@imagedelete');
	Route::resource('/newscategory', 'adminarea\News_controllers@newscategory');
	Route::resource('/addeditnewscategory', 'adminarea\News_controllers@addeditnewscategory');
	Route::resource('/saveMetaKeyword', 'adminarea\News_controllers@saveMetaKeyword');
	Route::resource('/newsorder', 'adminarea\News_controllers@newsorder');
	Route::resource('/saveorder', 'adminarea\News_controllers@saveorder');
});

/* For Add Portfolio */
Route::group(array('prefix' => 'adminarea/portfolio'), function()
{
	Route::resource('/', 'adminarea\Portfolio_controllers@index');
	Route::resource('/index', 'adminarea\Portfolio_controllers@index');
	Route::resource('/getReorder', 'adminarea\Portfolio_controllers@getReorder');
	Route::resource('/addeditportfolio', 'adminarea\Portfolio_controllers@addeditportfolio');
	Route::resource('/saveportfolio', 'adminarea\Portfolio_controllers@saveportfolio');
	Route::resource('/singledelete', 'adminarea\Portfolio_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Portfolio_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Portfolio_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Portfolio_controllers@singlestatus');
	Route::resource('/imagedelete', 'adminarea\Portfolio_controllers@imagedelete');
	Route::resource('/portfoliocategory', 'adminarea\Portfolio_controllers@portfoliocategory');
	Route::resource('/addeditportfoliocategory', 'adminarea\Portfolio_controllers@addeditportfoliocategory');
	Route::resource('/saveMetaKeyword', 'adminarea\Portfolio_controllers@saveMetaKeyword');
	Route::resource('/portfolioorder', 'adminarea\Portfolio_controllers@portfolioorder');
	Route::resource('/saveorder', 'adminarea\Portfolio_controllers@saveorder');
});

/* For Add Staff */
Route::group(array('prefix' => 'adminarea/staff'), function()
{
	Route::resource('/', 'adminarea\Staff_controllers@index');
	Route::resource('/index', 'adminarea\Staff_controllers@index');
	Route::resource('/addeditstaff', 'adminarea\Staff_controllers@addeditstaff');
	Route::resource('/savestaff', 'adminarea\Staff_controllers@savestaff');
	Route::resource('/singledelete', 'adminarea\Staff_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Staff_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Staff_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Staff_controllers@singlestatus');
	Route::resource('/imagedelete', 'adminarea\Staff_controllers@imagedelete');
	Route::resource('/staffcategory', 'adminarea\Staff_controllers@staffcategory');
	Route::resource('/addeditstaffcategory', 'adminarea\Staff_controllers@addeditstaffcategory');
	Route::resource('/stafforder', 'adminarea\Staff_controllers@stafforder');
	Route::resource('/saveorder', 'adminarea\Staff_controllers@saveorder');
});

/* For Add Testimonials */
Route::group(array('prefix' => 'adminarea/testimonials'), function()
{
	Route::resource('/', 'adminarea\Testimonials_controllers@index');
	Route::resource('/index', 'adminarea\Testimonials_controllers@index');
	Route::resource('/addedittestimonials', 'adminarea\Testimonials_controllers@addedittestimonials');
	Route::resource('/savetestimonials', 'adminarea\Testimonials_controllers@savetestimonials');
	Route::resource('/singledelete', 'adminarea\Testimonials_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Testimonials_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Testimonials_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Testimonials_controllers@singlestatus');
	Route::resource('/imagedelete', 'adminarea\Testimonials_controllers@imagedelete');
	Route::resource('/testimonialsorder', 'adminarea\Testimonials_controllers@testimonialsorder');
	Route::resource('/saveorder', 'adminarea\Testimonials_controllers@saveorder');
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
	Route::resource('/contactus', 'adminarea\Report_controllers@contactus');
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

/* For Add Products */
Route::group(array('prefix' => 'adminarea/product'), function()
{
	Route::resource('/', 'adminarea\Product_controllers@index');
	Route::resource('/index', 'adminarea\Product_controllers@index');
	Route::resource('/package', 'adminarea\Product_controllers@package');
	Route::resource('/getReorder', 'adminarea\Product_controllers@getReorder');
	Route::resource('/addeditproduct', 'adminarea\Product_controllers@addeditproduct');
	Route::resource('/saveproduct', 'adminarea\Product_controllers@saveproduct');
	Route::resource('/saveMainImage', 'adminarea\Product_controllers@saveMainImage');
	Route::resource('/singledelete', 'adminarea\Product_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Product_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Product_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Product_controllers@singlestatus');
	Route::resource('/imagedelete', 'adminarea\Product_controllers@imagedelete');
	Route::resource('/productcategory', 'adminarea\Product_controllers@productcategory');
	Route::resource('/addeditproductcategory', 'adminarea\Product_controllers@addeditproductcategory');
	Route::resource('/saveMetaKeyword', 'adminarea\Product_controllers@saveMetaKeyword');
	Route::resource('/productorder', 'adminarea\Product_controllers@productorder');
	Route::resource('/saveorder', 'adminarea\Product_controllers@saveorder');
	Route::resource('/saveproductcategory', 'adminarea\Product_controllers@saveproductcategory');
});

/* For Add Products Size */
Route::group(array('prefix' => 'adminarea/product_size'), function()
{
	Route::resource('/addeditproductsize', 'adminarea\Product_size_controllers@addeditproductsize');
	Route::resource('/savesize', 'adminarea\Product_size_controllers@savesize');
	Route::resource('/generalprodcutsize', 'adminarea\Product_size_controllers@generalprodcutsize');
});
/*

/* For Add Products Item */
Route::group(array('prefix' => 'adminarea/product_item'), function()
{
	Route::resource('/addeditproductitem', 'adminarea\Product_item_controllers@addeditproductitem');
	Route::resource('/saveitem', 'adminarea\Product_item_controllers@saveitem');
	Route::resource('/getsizeitem', 'adminarea\Product_item_controllers@getsizeitem');
});
/*

/* For Add Products Price */
Route::group(array('prefix' => 'adminarea/product_price'), function()
{
	Route::resource('/updateprice', 'adminarea\Product_price_controllers@updateprice');
	Route::resource('/saveproductprice', 'adminarea\Product_price_controllers@saveproductprice');
	Route::resource('/saveproductgolive', 'adminarea\Product_price_controllers@saveproductgolive');
	Route::resource('/singledelete', 'adminarea\Product_price_controllers@singledelete');
	Route::resource('/singlestatus', 'adminarea\Product_price_controllers@singlestatus');
	Route::resource('/addeditproductprice', 'adminarea\Product_price_controllers@addeditproductprice');
});

/* For Add Order */
Route::group(array('prefix' => 'adminarea/order'), function()
{
	Route::resource('/', 'adminarea\Order_controllers@index');
	Route::resource('/orderDetail', 'adminarea\Order_controllers@orderDetail');
	Route::resource('/rewardDetail', 'adminarea\Order_controllers@rewardDetail');
	Route::resource('/ordersingledelete', 'adminarea\Order_controllers@ordersingledelete');
	Route::resource('/changeOrderStatus', 'adminarea\Order_controllers@changeOrderStatus');
	Route::resource('/reward', 'adminarea\Order_controllers@reward');
});
/*

/* For Add Order */
Route::group(array('prefix' => 'adminarea/changepassword'), function()
{
	Route::resource('/', 'adminarea\Changepassword_controllers@index');
	Route::resource('/change_password', 'adminarea\Changepassword_controllers@change_password');
	Route::resource('/checkpassword', 'adminarea\Changepassword_controllers@checkpassword');
});
/*

/* For Add Coupon */
Route::group(array('prefix' => 'adminarea/coupon'), function()
{
	Route::resource('/', 'adminarea\Coupon_controllers@index');
	Route::resource('/index', 'adminarea\Coupon_controllers@index');
	Route::resource('/addeditcoupon', 'adminarea\Coupon_controllers@addeditcoupon');
	Route::resource('/savecoupon', 'adminarea\Coupon_controllers@savecoupon');
	Route::resource('/singledelete', 'adminarea\Coupon_controllers@singledelete');
	Route::resource('/multiplestatus', 'adminarea\Coupon_controllers@multiplestatus');
	Route::resource('/multipleDelete', 'adminarea\Coupon_controllers@multipleDelete');
	Route::resource('/singlestatus', 'adminarea\Coupon_controllers@singlestatus');
	Route::resource('/couponorder', 'adminarea\Coupon_controllers@couponorder');
	Route::resource('/saveorder', 'adminarea\Coupon_controllers@saveorder');
});
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
	Route::resource('/addtocartunpaid', 'Action_controllers@addtocartunpaid');
	Route::resource('/addcuopon', 'Action_controllers@addcuopon');
	Route::resource('/removecoupon', 'Action_controllers@removecoupon');
	Route::resource('/checkoutshippingaction', 'Action_controllers@checkoutshippingaction');
	Route::resource('/checkoutbillingaction', 'Action_controllers@checkoutbillingaction');
	Route::resource('/myprofile', 'Action_controllers@myprofile');
	Route::resource('/getPriceTotal', 'Action_controllers@getPriceTotal');
	Route::resource('/customeraddressaddedit', 'Action_controllers@customeraddressaddedit');
	Route::resource('/changepassword', 'Action_controllers@changepassword');
	Route::resource('/forgotpassword', 'Action_controllers@forgotpassword');
	Route::resource('/resetpassword', 'Action_controllers@resetpassword');
	Route::resource('/getProductorderTotalCount', 'Action_controllers@getProductorderTotalCount');
       
        Route::post('/addcomment','Action_controllers@SaveComment');
	
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
	Route::resource('/fblogin', 'Signup_controllers@fblogin');
	Route::resource('/login', 'Signup_controllers@login');
	Route::resource('/login/dashboard', 'Signup_controllers@login');
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

Route::post('/stripeconfirm', 'Signup_controllers@stripeConfirm');
Route::get('/stripeconfirm', 'Signup_controllers@stripeConfirm');

Route::get('/{filename?}', 'Pages_controllers@index');
Route::post('/{filename?}', 'Pages_controllers@index');
Route::resource('/{filename?}/{urlName?}', 'Pages_controllers@index');

/*
|--------------------------------------------------------------------------
| End For Front-End
|--------------------------------------------------------------------------
*/
