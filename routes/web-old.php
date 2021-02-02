<?php

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

Auth::routes();


Route::get('refreshcaptcha', 'HomeController@refreshCaptcha');

//Route::get('/', 'HomeController@index')->name('name');
//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/index.html', 'HomeController@index')->name('home');
Route::get('login.html', 'HomeController@login');

Route::get('lock.html', 'HomeController@lock');

Route::post('login.html', 'HomeController@checkLogin')->name('login.html');

Route::get('/terms.html', 'HomeController@terms');
Route::get('/about.html', 'HomeController@about');
Route::get('faq.html', 'HomeController@faq');
Route::get('/contact.html', 'HomeController@contact');
Route::post('contact.html', 'HomeController@contactSend')->name('contact.html');

Route::get('test.html', 'HomeController@test');
Route::get('wallet.html', 'HomeController@wallet');
Route::get('checkcodemelli.html', 'HomeController@checkCodemelli')->name('checkcodemelli.html');
Route::get('lan.html', 'HomeController@testLang');
Route::get('sendUser', 'HomeController@sendUser');

Route::get('/main/alertc/{id}', 'HomeController@alertc');
Route::get('/ostanSelect', 'HomeController@changeOstan');

Route::get('/pahne', 'HomeController@pahne');

Route::get('pay/{id}', 'SadadBankController@pay');
Route::get('b', 'SadadBankController@verify')->name('verify');

Route::get('sep/verify.php', 'SepBankController@verify')->name('sep/verify.php');
Route::get('sep/{id}', 'SepBankController@pay');
Route::post('sep/verify', 'SepBankController@back');

 Route::get('/', 'ProfileController@index')->middleware('check.info.user','auth')->name('home');
 Route::get('/home', 'ProfileController@index')->middleware('check.info.user','auth')->name('home');
 Route::get('/index.html', 'ProfileController@index')->middleware('check.info.user','auth')->name('home');

Route::get('generate-pdf','HomeController@generatePDF');


Route::get('home/lock_broker.html', 'HomeController@lockBroker');

Route::get('importExcel',array('as'=>'excel.import','uses'=>'FileController@importExportExcelORCSV'));
Route::post('import-csv-excel',array('as'=>'import-csv-excel','uses'=>'FileController@importFileIntoDB'));
Route::get('download-excel-file/{type}', array('as'=>'excel-file','uses'=>'FileController@downloadExcelFile'));

Route::get('resetPassword.html', 'HomeController@resetPasswordForm');
Route::post('resetPasswordSend.html', 'HomeController@resetPassword')->name('resetPasswordSend.html');
Route::get('resetPasswordComplate.html', 'HomeController@resetPasswordSend');
Route::post('resetPasswordComplate.html', 'HomeController@resetPasswordComplate')->name('resetPasswordComplate');
Route::get('newPassword.html', 'HomeController@newPasswordForm');
Route::post('newPassword.html', 'HomeController@newPassword')->name('newPassword');
// ****************************** Profile **********************
Route::get('profile/checkInfo.html', 'ProfileController@checkInfo');
Route::post('infoValid', 'ProfileController@validCheckInfo')->name('infoValid');
Route::get('infoUnValid', 'ProfileController@unValidCheckInfo');
Route::get('profile/index.html', 'ProfileController@index')->middleware('check.info.user','auth');
Route::get('profile/copon.html', 'ProfileController@copon')->middleware('check.info.user','auth');
Route::get('profile/changeInfo.html', 'ProfileController@changeInfo')->middleware('check.info.user','auth');
Route::post('profile/changeInfo.html', 'ProfileController@update')->middleware('check.info.user','auth')->name('profile/changeInfo.html');
Route::get('profile/validationInfo.html', 'ProfileController@validationInfo')->middleware('auth');
Route::post('profile/validationInfo.html', 'ProfileController@updateValidationInfo')->name('profile/validationInfo.html')->middleware('auth');
Route::get('profile/changePassword.html', 'ProfileController@changePassword')->middleware('check.info.user','auth');
Route::post('profile/changePassword.html', 'ProfileController@updatePassword')->middleware('check.info.user','auth')->name('profile/changePassword.html');
// ****************************** Admin **********************
Route::get('admin/index.html', 'AdminController@index')->middleware('auth');
Route::get('admin', 'AdminController@index')->middleware('auth');
// *********************   User   **************************
Route::get('/user/all', 'UserController@all')->middleware('auth');
Route::get('/user/kargozar', 'UserController@kargozar')->middleware('auth');
Route::get('/user/create', 'UserController@create')->middleware('auth');
Route::post('/user/store', 'UserController@store')->name('user/store')->middleware('auth');
Route::delete('/user/{id}', 'UserController@destroy')->name('user/delete')->middleware('auth');
Route::get('/user/{id}/edit', 'UserController@edit')->middleware('auth');
Route::put('/user/{id}', 'UserController@update')->name('user/update')->middleware('auth');
Route::get('/user/{id}', 'UserController@show')->middleware('auth');
Route::get('user/{id}/koodList', 'UserController@koodList')->middleware('auth');
Route::post('user/{id}/koodList', 'UserController@storeKoodList')->name('user/koodList')->middleware('auth');
// *********************   Tahvil   **************************
Route::get('/tahvil/all', 'TahvilController@all')->middleware('auth');
Route::delete('/tahvil/{id}', 'TahvilController@destroy')->name('tahvil/delete')->middleware('auth');
// *********************   Bahrebardar   **************************
Route::get('bahrebardar/index.html', 'BahrebardarController@index')->middleware('auth');
Route::get('/bahrebardar/all', 'BahrebardarController@all')->middleware('auth');
Route::get('/bahrebardar/list', 'BahrebardarController@listBah')->middleware('auth');
Route::get('/bahrebardar/create', 'BahrebardarController@create')->middleware('auth');
Route::post('/bahrebardar/store', 'BahrebardarController@store')->name('bahrebardar/store')->middleware('auth');
Route::get('/bahrebardar/new', 'BahrebardarController@newRequest')->middleware('auth');
Route::post('/bahrebardar/new', 'BahrebardarController@saveRequest')->name('bahrebardar/new')->middleware('auth');
Route::delete('/bahrebardar/{id}', 'BahrebardarController@destroy')->name('bahrebardar/delete')->middleware('auth');
Route::get('/bahrebardar/{id}/edit', 'BahrebardarController@edit')->middleware('auth');
Route::put('/bahrebardar/{id}', 'BahrebardarController@update')->name('bahrebardar/update')->middleware('auth');
Route::get('/bahrebardar/{id}', 'BahrebardarController@show')->middleware('auth');
// *********************   Clinic   **************************
Route::get('clinic/index.html', 'ClinicController@index')->middleware('auth');
Route::get('/clinic/all', 'ClinicController@all')->middleware('auth');
Route::get('/clinic/list', 'ClinicController@listBah')->middleware('auth');
Route::get('/clinic/create', 'ClinicController@create')->middleware('auth');
Route::post('/clinic/store', 'ClinicController@store')->name('clinic/store')->middleware('auth');
Route::get('/clinic/new', 'ClinicController@newRequest')->middleware('auth');
Route::post('/clinic/new', 'ClinicController@saveRequest')->name('clinic/new')->middleware('auth');
Route::delete('/clinic/{id}', 'ClinicController@destroy')->name('clinic/delete')->middleware('auth');
Route::get('/clinic/{id}/edit', 'ClinicController@edit')->middleware('auth');
Route::put('/clinic/{id}', 'ClinicController@update')->name('clinic/update')->middleware('auth');
Route::get('/clinic/{id}', 'ClinicController@show')->middleware('auth');
// *********************   Store   **************************
Route::get('store/index.html', 'StoreController@index')->middleware('auth');
Route::get('/store/all', 'StoreController@all')->middleware('auth');
Route::get('/store/list', 'StoreController@listBah')->middleware('auth');
Route::get('/store/create', 'StoreController@create')->middleware('auth');
Route::post('/store/store', 'StoreController@store')->name('store/store')->middleware('auth');
Route::get('/store/new', 'StoreController@newRequest')->middleware('auth');
Route::post('/store/new', 'StoreController@saveRequest')->name('store/new')->middleware('auth');
Route::delete('/store/{id}', 'StoreController@destroy')->name('store/delete')->middleware('auth');
Route::get('/store/{id}/edit', 'StoreController@edit')->middleware('auth');
Route::put('/store/{id}', 'StoreController@update')->name('store/update')->middleware('auth');
Route::get('/store/{id}', 'StoreController@show')->middleware('auth');
// *********************   Kargozar   **************************
Route::get('kargozar/index.html', 'KargozarController@index')->middleware('auth');
Route::get('/kargozar/all', 'KargozarController@all')->middleware('auth');
Route::get('/kargozar/list', 'KargozarController@listBah')->middleware('auth');
Route::get('/kargozar/create', 'KargozarController@create')->middleware('auth');
Route::post('/kargozar/store', 'KargozarController@store')->name('kargozar/store')->middleware('auth');
Route::get('/kargozar/new', 'KargozarController@newRequest')->middleware('auth');
Route::post('/kargozar/new', 'KargozarController@saveRequest')->name('kargozar/new')->middleware('auth');
Route::delete('/kargozar/{id}', 'KargozarController@destroy')->name('kargozar/delete')->middleware('auth');
Route::get('/kargozar/{id}/edit', 'KargozarController@edit')->middleware('auth');
Route::put('/kargozar/{id}', 'KargozarController@update')->name('kargozar/update')->middleware('auth');
Route::get('/kargozar/{id}', 'KargozarController@show')->middleware('auth');
// *********************   DafAfat   **************************
Route::get('dafAfat/index.html', 'DafAfatController@index')->middleware('auth');
Route::get('/dafAfat/all', 'DafAfatController@all')->middleware('auth');
Route::get('/dafAfat/list', 'DafAfatController@listBah')->middleware('auth');
Route::get('/dafAfat/create', 'DafAfatController@create')->middleware('auth');
Route::post('/dafAfat/store', 'DafAfatController@store')->name('dafAfat/store')->middleware('auth');
Route::get('/dafAfat/new', 'DafAfatController@newRequest')->middleware('auth');
Route::post('/dafAfat/new', 'DafAfatController@saveRequest')->name('dafAfat/new')->middleware('auth');
Route::delete('/dafAfat/{id}', 'DafAfatController@destroy')->name('dafAfat/delete')->middleware('auth');
Route::get('/dafAfat/{id}/edit', 'DafAfatController@edit')->middleware('auth');
Route::put('/dafAfat/{id}', 'DafAfatController@update')->name('dafAfat/update')->middleware('auth');
Route::get('/dafAfat/{id}', 'DafAfatController@show')->middleware('auth');


// *********************   Insectarium   **************************
Route::get('insectarium/index.html', 'InsectariumController@index')->middleware('auth');
Route::get('/insectarium/list', 'InsectariumController@listBah')->middleware('auth');
Route::get('/insectarium/new', 'InsectariumController@newRequest')->middleware('auth');
Route::post('/insectarium/new', 'InsectariumController@saveRequest')->name('insectarium/new')->middleware('auth');

// *********************   Azmayeshgah   **************************
Route::get('azmayeshgah/index.html', 'AzmayeshgahController@index')->middleware('auth');
Route::get('/azmayeshgah/list', 'AzmayeshgahController@listBah')->middleware('auth');
Route::get('/azmayeshgah/new', 'AzmayeshgahController@newRequest')->middleware('auth');
Route::post('/azmayeshgah/new', 'AzmayeshgahController@saveRequest')->name('azmayeshgah/new')->middleware('auth');

// *********************   koodReq   **************************
Route::get('/koodReq/list', 'KoodReqController@all')->middleware('auth');
Route::get('/koodReq/create/{id}', 'KoodReqController@create')->middleware('auth');
Route::post('/koodReq/store', 'KoodReqController@store')->name('koodReq/store')->middleware('auth');
Route::get('koodReq/checkKood', 'KoodReqController@checkKood')->middleware('auth');
Route::get('koodReq/{id}/view', 'KoodReqController@view');


Route::get('koodReq/cart', 'KoodReqController@cart')->middleware('auth');
Route::get('koodReq/remove/{id}', 'KoodReqController@removeCard')->middleware('auth');
Route::post('koodReq/endSale', 'KoodReqController@endSale')->middleware('auth');
// *********************   koodReqShotooi   **************************
Route::get('/koodReqShotooi/list', 'KoodReqShotooiController@all')->middleware('auth');
Route::get('/koodReqShotooi/create/{id}', 'KoodReqShotooiController@create')->middleware('auth');
Route::post('/koodReqShotooi/store', 'KoodReqShotooiController@store')->name('koodReqShotooi/store')->middleware('auth');
Route::get('koodReqShotooi/checkKood', 'KoodReqShotooiController@checkKood')->middleware('auth');
Route::get('koodReqShotooi/{id}/view', 'KoodReqShotooiController@view');


Route::get('koodReqShotooi/cart', 'KoodReqShotooiController@cart')->middleware('auth');
Route::get('koodReqShotooi/remove/{id}', 'KoodReqShotooiController@removeCard')->middleware('auth');
Route::post('koodReqShotooi/endSale', 'KoodReqShotooiController@endSale')->middleware('auth');
// *********************   brokerKoodReq   **************************
Route::get('brokerKoodReq/list', 'BrokerKoodReqController@all')->middleware('auth');
Route::get('brokerKoodReq/sendList', 'BrokerKoodReqController@allSend')->middleware('auth');
Route::get('brokerKoodReq/backList', 'BrokerKoodReqController@allBack')->middleware('auth');
Route::get('brokerKoodReq/lastList', 'BrokerKoodReqController@allLast')->middleware('auth');
Route::get('brokerKoodReq/{id}/view', 'BrokerKoodReqController@view')->middleware('auth');
Route::get('brokerKoodReq/{id}/check', 'BrokerKoodReqController@check')->middleware('auth');
Route::get('brokerKoodReq/{id}/back', 'BrokerKoodReqController@back')->middleware('auth');

// *********************   request   **************************
Route::get('/request/sam/create', 'RequestController@createSam')->middleware('auth');
Route::get('/request/sam/createManager', 'RequestController@createSamManager')->middleware('auth');
Route::post('/request/sam/store', 'RequestController@storeSam')->name('request/sam/store')->middleware('auth');
Route::post('/request/sam/storeManager', 'RequestController@storeSamManager')->name('request/sam/storeManager')->middleware('auth');
Route::get('/request/getFile/{id}', 'RequestController@getFile')->middleware('auth');
Route::post('/request/getFile/{id}', 'RequestController@saveFile')->name('request/getFile')->middleware('auth');
Route::get('/request/endSave/{id}', 'RequestController@endSave')->middleware('auth');
Route::get('/request/{id}/userClinic', 'RequestController@userClinic')->middleware('auth');
Route::get('/request/clinicList', 'RequestController@clinicList')->middleware('auth');
Route::get('/request/clinicView/{id}/noskhe', 'RequestController@noskheView')->middleware('auth');
Route::get('/request/clinicView/{id}', 'RequestController@clinicView')->middleware('auth');
Route::get('/request/needFile/{id}', 'RequestController@needFile')->middleware('auth');
Route::get('/request/needView/{id}', 'RequestController@needView')->middleware('auth');
Route::get('/request/needAzmayesh/{id}', 'RequestController@needAzmayesh')->middleware('auth');
Route::get('/request/needInstkario/{id}', 'RequestController@needInstkario')->middleware('auth');
Route::get('/request/alertNoskhe/{id}','RequestController@alertNoskhe')->middleware('auth');
Route::get('/request/list', 'RequestController@listUser')->middleware('auth');
Route::get('/request/clinicSelect/{id}','RequestController@clinicSelect')->middleware('auth');
Route::get('/request/sendNoskhe/{id}', 'RequestController@sendNoskhe')->name('request/sendNoskhe')->middleware('auth');
Route::post('/request/saveNoskhe', 'RequestController@saveNoskhe')->name('request/saveNoskhe')->middleware('auth');
Route::get('/request/saveItemNoskhe', 'RequestController@storeItemNoskhe')->middleware('auth');
Route::get('/request/deleteItemNoskhe', 'RequestController@deleteItemNoskhe')->name('/request/deleteItemNoskhe')->middleware('auth');
Route::get('/request/reciptNoskhe/{id}/clinic', 'RequestController@reciptClinic')->middleware('auth');
Route::put('/request/saveRequestStore/{id}', 'RequestController@saveRequestStore')->name('request/saveRequestStore')->middleware('auth');
Route::get('/request/storeList', 'RequestController@storeList')->middleware('auth');
Route::get('/request/storeView/{id}', 'RequestController@storeView')->middleware('auth');
Route::post('/request/sendAnswerStore/{id}', 'RequestController@sendAnswerStore')->name('request/sendAnswerStore')->middleware('auth');
Route::get('/request/storeSelect/{id}', 'RequestController@storeSelect')->middleware('auth');
Route::get('/request/other/{id}', 'RequestController@otherService')->middleware('auth');
Route::post('/request/saveOther/{id}', 'RequestController@saveOther')->name('request/saveOther')->middleware('auth');
Route::get('/request/afatkoshShopList', 'RequestController@afatkoshShopList')->middleware('auth');
Route::get('/request/afatkoshShopView/{id}', 'RequestController@afatkoshShopView')->middleware('auth');
Route::post('/request/sendAnswerAfatkoshShop/{id}', 'RequestController@sendAnswerAfatkoshShop')->name('request/sendAnswerAfatkoshShop')->middleware('auth');
Route::get('/request/afatkoshShopSelect/{id}', 'RequestController@afatkoshShopSelect')->middleware('auth');
Route::get('/request/afatkoshView/{id}', 'RequestController@afatkoshView')->middleware('auth');

Route::get('/request/checkType', 'RequestController@checkType')->name('request/checkType')->middleware('auth');
Route::get('/request/rate', 'RequestController@rate')->name('request/rate')->middleware('auth');


Route::get('/request/kood/create', 'RequestController@createKood')->middleware('auth');
Route::post('/request/kood/store', 'RequestController@storeKood')->name('request/kood/store')->middleware('auth');
Route::get('/request/kood/view/{id}', 'RequestController@koodView')->middleware('auth');

Route::get('/request/listPahne', 'RequestController@listPahne')->middleware('auth');
Route::get('/request/{id}/checkPahne', 'RequestController@checkPahne')->middleware('auth');
Route::get('/request/checkOk/{id}', 'RequestController@checkOk')->middleware('auth');
Route::put('/request/checkNotOk/{id}', 'RequestController@checkNotOk')->name('request/checkNotOk')->middleware('auth');

Route::post('/request/kood/sendAnswerStore/{id}', 'RequestController@sendAnswerStore')->name('request/kood/sendAnswerStore')->middleware('auth');
Route::get('/request/kood/storeSelect/{id}', 'RequestController@storeSelect')->middleware('auth');


Route::get('/request/reciptNoskhe/{id}/store', 'RequestController@reciptStore')->middleware('auth');

// *********************   samRequest   **************************

Route::get('/samRequest/all', 'SamRequestController@all')->middleware('auth');



Route::get('/samRequest/okNoskhe/{id}','SamRequestController@okNoskhe')->middleware('auth');


Route::get('/samRequest/{id}/storeRequest', 'SamRequestController@storeRequest')->middleware('auth');


Route::get('/samRequest/new', 'SamRequestController@newRequest')->middleware('auth');
Route::post('/samRequest/new', 'SamRequestController@saveRequest')->name('samRequest/new')->middleware('auth');
Route::delete('/samRequest/{id}', 'SamRequestController@destroy')->name('samRequest/delete')->middleware('auth');
Route::get('/samRequest/{id}/edit', 'SamRequestController@edit')->middleware('auth');
Route::put('/samRequest/{id}', 'SamRequestController@update')->name('samRequest/update')->middleware('auth');
Route::get('/samRequest/{id}/checkPahne', 'SamRequestController@checkPahne')->middleware('auth');
Route::put('/samRequest/{id}', 'SamRequestController@SaveCheckPahne')->name('samRequest/checkPahne')->middleware('auth');
Route::get('/samRequest/{id}', 'SamRequestController@show')->middleware('auth');



// ************************************************************************

Route::get('/prod/addCard/{id}/{numb}', 'ProdController@addToCard');
Route::get('/prod/inc', 'ProdController@incCard');
Route::get('/prod/getAddress', 'ProdController@getAddress')->middleware('auth');
Route::post('/prod/recipt', 'ProdController@recipt')->middleware('auth');
Route::get('/prod/end/{id}', 'ProdController@endRecipt')->middleware('auth');
Route::get('/prod/remove/{id}', 'ProdController@removeCard');
Route::get('/prod/cart', 'ProdController@cart');
Route::post('/prod/endSale', 'ProdController@endSale')->middleware('auth');

// ******************************** Bazdid Request *******************************
Route::get('bazdidRequest/index.html', 'BazdidRequestController@index')->middleware('auth');
Route::get('/bazdidRequest/all', 'BazdidRequestController@all')->middleware('auth');
Route::get('/bazdidRequest/list', 'BazdidRequestController@listReq')->middleware('auth');
Route::get('/bazdidRequest/create', 'BazdidRequestController@create')->middleware('auth');
Route::get('/bazdidRequest/create/{req}/{clinic}', 'BazdidRequestController@create')->middleware('auth');
Route::post('/bazdidRequest/store', 'BazdidRequestController@store')->name('bazdidRequest/store')->middleware('auth');
Route::delete('/bazdidRequest/{id}', 'BazdidRequestController@destroy')->name('bazdidRequest/delete')->middleware('auth');
Route::get('/bazdidRequest/{id}/edit', 'BazdidRequestController@edit')->middleware('auth');
Route::put('/bazdidRequest/{id}', 'BazdidRequestController@update')->name('bazdidRequest/update')->middleware('auth');
Route::get('/bazdidRequest/{id}', 'BazdidRequestController@show')->middleware('auth');
// ******************************** Handy Request *******************************
Route::get('handy/index.html', 'HandyController@index')->middleware('auth');
Route::get('/handy/all', 'HandyController@all')->middleware('auth');
Route::get('/handy/create', 'HandyController@create')->middleware('auth');
Route::post('/handy/store', 'HandyController@store')->name('handy/store')->middleware('auth');
Route::delete('/handy/{id}', 'HandyController@destroy')->name('handy/delete')->middleware('auth');
Route::get('/handy/{id}/edit', 'HandyController@edit')->middleware('auth');
Route::get('/handy/{id}/item', 'HandyController@item')->middleware('auth');
Route::put('/handy/{id}', 'HandyController@update')->name('handy/update')->middleware('auth');
// ******************************** HandyValue Request *******************************
Route::get('handyValue/index.html', 'HandyValueController@index')->middleware('auth');
Route::get('/handyValue/all/{item}', 'HandyValueController@all')->middleware('auth');
Route::get('/handyValue/create/{id}', 'HandyValueController@create')->middleware('auth');
Route::post('/handyValue/store', 'HandyValueController@store')->name('handyValue/store')->middleware('auth');
Route::delete('/handyValue/{id}', 'HandyValueController@destroy')->name('handyValue/delete')->middleware('auth');
Route::get('/handyValue/{id}/edit', 'HandyValueController@edit')->middleware('auth');
Route::put('/handyValue/{id}', 'HandyValueController@update')->name('handyValue/update')->middleware('auth');
// ******************************** CityKood Request *******************************
Route::get('cityKood/all', 'CityKoodController@all')->middleware('auth');
Route::get('cityKood/{id}/view', 'CityKoodController@view')->middleware('auth');
Route::get('cityKood/{id}/add/{kood}', 'CityKoodController@add')->middleware('auth');
Route::post('cityKood/add', 'CityKoodController@store')->name('cityKood/store')->middleware('auth');
Route::get('cityKood/{id}/remove/{kood}', 'CityKoodController@remove')->middleware('auth');
Route::post('cityKood/remove', 'CityKoodController@removeKood')->name('cityKood/remove')->middleware('auth');
// ******************************** BrokerKood Request *******************************
Route::get('brokerKood/all', 'BrokerKoodController@all')->middleware('auth');
Route::get('brokerKood/{id}/view', 'BrokerKoodController@view')->middleware('auth');
Route::get('brokerKood/view', 'BrokerKoodController@brokerView')->middleware('auth');
Route::get('brokerKood/report/{id}/{broker}', 'BrokerKoodController@brokerReport')->middleware('auth');
Route::get('brokerKood/report/{id}', 'BrokerKoodController@brokerReport')->middleware('auth');
Route::get('brokerKood/{id}/add/{kood}', 'BrokerKoodController@add')->middleware('auth');
Route::post('brokerKood/add', 'BrokerKoodController@store')->name('brokerKood/store')->middleware('auth');
Route::get('brokerKood/{id}/remove/{kood}', 'BrokerKoodController@remove')->middleware('auth');
Route::post('brokerKood/remove', 'BrokerKoodController@removeKood')->name('brokerKood/remove')->middleware('auth');

// *********************   Product   **************************
Route::get('product/all', 'ProductController@all')->middleware('auth');
Route::get('product/create', 'ProductController@create')->middleware('auth');
Route::post('product/store', 'ProductController@store')->name('product/store')->middleware('auth');
Route::delete('product/{id}', 'ProductController@destroy')->name('product/delete')->middleware('auth');
Route::get('product/{id}/edit', 'ProductController@edit')->middleware('auth');
Route::put('product/{id}', 'ProductController@update')->name('product/update')->middleware('auth');
// *********************   Kood   **************************
Route::get('kood/all', 'KoodController@all')->middleware('auth');
Route::get('kood/create', 'KoodController@create')->middleware('auth');
Route::post('kood/store', 'KoodController@store')->name('kood/store')->middleware('auth');
Route::delete('kood/{id}', 'KoodController@destroy')->name('kood/delete')->middleware('auth');
Route::get('kood/{id}/edit', 'KoodController@edit')->middleware('auth');
Route::put('kood/{id}', 'KoodController@update')->name('kood/update')->middleware('auth');
// *********************   Report   **************************
Route::get('report/city', 'ReportController@cities')->middleware('auth');
Route::get('report/brokerCity', 'ReportController@cityBrokers')->middleware('auth');
Route::get('report/city/{id}', 'ReportController@brokers')->middleware('auth');
Route::get('report/broker/{id}', 'ReportController@farmers')->middleware('auth');
// *********************   ProductKoodValue   **************************
Route::get('productKoodValue/all', 'ProductKoodValueController@all')->middleware('auth');
Route::get('productKoodValue/create', 'ProductKoodValueController@create')->middleware('auth');
Route::post('productKoodValue/store', 'ProductKoodValueController@store')->name('productKoodValue/store')->middleware('auth');
Route::delete('productKoodValue/{id}', 'ProductKoodValueController@destroy')->name('productKoodValue/delete')->middleware('auth');
Route::get('productKoodValue/{id}/edit', 'ProductKoodValueController@edit')->middleware('auth');
Route::put('productKoodValue/{id}', 'ProductKoodValueController@update')->name('productKoodValue/update')->middleware('auth');

// *********************  userReq *********************
Route::get('userReq/Declarative/{id}','KoodReqController@ezhar');
Route::post('userReq/DeclarativePost/{id}', 'KoodReqController@ezharPost')->name('userReq/DeclarativePost');
Route::get('userReq/pay/{id}','KoodReqController@ezharPay');
Route::post('userReq/ezharPay/{id}', 'KoodReqController@ezharPayEnd')->name('userReq/ezharPay');
// *********************  Report **********************
Route::get('report/koods', 'ReportController@koodRep');
Route::post('report/koodPost', 'ReportController@koodPost')->name('report/koodPost');

Route::get('report/brokerKoods', 'ReportController@brokerRep');
Route::post('report/brokerKoods', 'ReportController@brokerRep')->name('report/brokerKoods');

Route::get('report/ostanReport', 'ReportController@ostanReport');
Route::post('report/ostanReport', 'ReportController@ostanReport')->name('report/ostanReport');

Route::get('report/getbroker', 'ReportController@getBroker');
Route::get('report/getbroker/user', 'ReportController@brokerCity')->name('report/getbroker/user');

Route::get('report/getuser', 'ReportController@getUser');
// *********************   BankFile   **************************
Route::get('bankFile/all', 'BankFileController@all')->middleware('auth');
Route::get('bankFile/create', 'BankFileController@create')->middleware('auth');
Route::post('bankFile/store', 'BankFileController@store')->name('bankFile/store')->middleware('auth');
Route::delete('bankFile/{id}', 'BankFileController@destroy')->name('bankFile/delete')->middleware('auth');
Route::get('bankFile/{id}/edit', 'BankFileController@edit')->middleware('auth');
Route::put('bankFile/{id}', 'BankFileController@update')->name('bankFile/update')->middleware('auth');

