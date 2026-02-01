<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\TravelersRegisterController;
use App\Http\Controllers\TravelerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/',[TravelersRegisterController::class,'welcome'])->name('welcome');
Route::get('/login',[TravelersRegisterController::class,'login'])->name('login')->middleware('logged');
Route::get('/error',[TravelersRegisterController::class,'errorPage'])->name('errorPage');
Route::get('/verify/user',[TravelersRegisterController::class,'signIn'])->name('signIn');
route::get('/sign-out',[TravelersRegisterController::class,'signOut'])->name('signOut');

Route::get('/home/{useruuid}',[UserController::class,'travelersRegisterHome'])->name('travelersRegisterHome')->middleware('verificationUser');
Route::get('/registro-de-viajero/{useruuid}',[TravelerController::class,'travelerRegistration'])->name('travelerRegistration')->middleware('verificationUser');
// form to register travel
Route::get('/formulario/{token}/registrar-viajero/',[TravelerController::class,'showFormRegisterTravel'])->name('showFormRegisterTravel')->middleware('verifyFormTokenOfTravel');
// action register travel
Route::post('registrar/new/viajero',[TravelerController::class,'registerTravel'])->name('registerTravel');
//  EDIT TRAVEL TO FORM
Route::get('{useruuid}/edit/travel/form/{traveluuid}',[TravelerController::class,'getFormToEditTravel'])->name('getFormToEditTravel')->middleware('verificationUser');
// ACTION REGISTER TO TRAVEL
Route::post('{useruuid}/new/edit/travel/{traveluuid}',[TravelerController::class,'editTravel'])->name('editTravel')->middleware('verificationUser');
// ACTION DELETE TRAVEL
Route::post('{useruuid}/delete/travel',[TravelerController::class,'deleteTravel'])->name('deleteTravel')->middleware('verificationUser');
// ACTION GET URL TO FORM TRAVEL
Route::post('{useruuid}/generate/url/travel',[TravelerController::class,'generateTemporaryUrl'])->name('generateTemporaryUrl')->middleware('verificationUser');

Route::get('{useruuid}/travel/registered/{traveluuid}',[TravelerController::class,'getSpecificTravel'])->name('getSpecificTravel')->middleware('verificationUser');

Route::get('/travel/registered/success',[TravelerController::class,'pageSuccessRegisterTravel'])->name('pageSuccessRegisterTravel');

Route::get('/politic-and-privacity',[TravelersRegisterController::class,'politicAndPrivacy'])->name('politicAndPrivacy');

// INVOICE

// HOME INVOICE
Route::get('{useruuid}/invoice/home',[InvoiceController::class,'homeInvoice'])->name('homeInvoice')->middleware('verificationUser');

// GET FORM TO REGISTER FATURE
Route::get('register/invoice/form',[InvoiceController::class,'getFormOfRegisterInvoice'])->name('getFormOfRegisterInvoice')->middleware('verificationUser');

// REGISTER NEW INVOICE 
Route::post('{useruuid}/register/invoice',[InvoiceController::class,'registerInvoice'])->name('registerInvoice')->middleware('verificationUser');

// SHOW SPECIFIC INVOICE
Route::get('{useruuid}/invoice/{invoiceuuid}',[InvoiceController::class,'showSpecificInvoice'])->name('showSpecificInvoice')->middleware('verificationUser');

// SHOW FORM TO BILLING DATA
Route::get('{useruuid}/billing-data/',[InvoiceController::class,'billingData'])->name('billingData')->middleware('verificationUser');

// REGISTER BILLING DATA
Route::post('{useruuid}/billing-data/register',[InvoiceController::class,'registerBillingData'])->name('registerBillingData')->middleware('verificationUser');

// EDIT BILLING DATA
Route::post('{useruuid}/billing-data/edit{billinguuid}',[InvoiceController::class,'editBillingData'])->name('editBillingData')->middleware('verificationUser');

// DONWLOAD XML 
Route::post('{useruuid}/downloadXML/travel{traveluuid}',[TravelerController::class,'downloadXML'])->name('downloadXML');

// SHOW BOOKING INDEX
Route::get('{useruuid}/booking-index/',[BookingController::class,'bookingIndex'])->name('bookingIndex')->middleware('verificationUser');

// REGISTER NEW BOOKING OR EDIT  
Route::post('{useruuid}/register-or-edit-booking/',[BookingController::class,'registerOrEdit'])->name('registerOrEdit')->middleware('verificationUser');
// DELETE SPECIFIC BOOKING
Route::post('{useruuid}/delete-booking/',[BookingController::class,'deleteSpecificBooking'])->name('deleteSpecificBooking')->middleware('verificationUser');

// DESCARGAR CALENDARIO 
Route::get('/calendario.ics/{token}', [BookingController::class, 'exportICal']);

// SINCRONIZAR EL MOTOR DE RESERVA CON BOOKING
Route::get('/sync-booking/{token}', [BookingController::class, 'importToBooking']);





// USERS
// ALL USER HOME
Route::get('user/{token}/all-users/', [UserController::class, 'allUserHome'])->name('allUserHome')->middleware('verificationUser');
// HOME CREATE OR EDIT USER
Route::get('user/{token}/create/', [UserController::class, 'createOrEditUserIndex'])->name('createOrEditUserIndex')->middleware('verificationUser');
Route::get('user/{token}/edit/{uuid}', [UserController::class, 'createOrEditUserIndex'])->name('editUserForm')->middleware('verificationUser');
// ACTIONS CREATE OR EDIT USER
Route::post('user/{token}/create/', [UserController::class, 'store'])->name('storeUser')->middleware('verificationUser');
Route::put('user/{token}/edit/{uuid}', [UserController::class, 'update'])->name('updateUser')->middleware('verificationUser');
Route::post('user/{token}/delete/{uuid}', [UserController::class, 'destroy'])->name('deleteUser')->middleware('verificationUser');
