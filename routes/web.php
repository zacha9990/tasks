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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');


Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm')->name('login.admin');
Route::get('/login/employee', 'Auth\LoginController@showEmployeeLoginForm')->name('login.employee');
// Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
// Route::get('/register/writer', 'Auth\RegisterController@showWriterRegisterForm');

Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/login/employee', 'Auth\LoginController@memberLogin');
// Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
// Route::post('/register/writer', 'Auth\RegisterController@createWriter');

Route::view('/home', 'home')->middleware('auth');
Route::view('/admin', 'admin');
Route::view('/employee', 'employee');

Route::resource('/datatables', 'BookController', [
    'anyData'  => 'datatables.data',
    'getIndex' => 'datatables',
]);

Route::resource('/books', 'BookController');
Route::resource('/users', 'UserController');
Route::resource('/employees', 'EmployeeController');
Route::resource('/borrows', 'BorrowController');
Route::resource('/educations', 'EducationController');
Route::resource('/positions', 'PositionController');


Route::get('/bookview', 'BookController@anyData');
Route::get('/userview', 'UserController@all_user_yajra')->name('user.lists');
Route::get('/employeeview', 'EmployeeController@all_employee_yajra')->name('employee.lists');
Route::get('/positionsview', 'PositionController@all_position_yajra')->name('position.lists');
Route::get('/educationview', 'EducationController@all_education_yajra')->name('education.lists');

Route::get('/deleteBook/{book}', 'BookController@deleteBook')->name('bookss.delete');
Route::get('/deleteUser/{user}', 'UserController@deleteUser')->name('userss.delete');
Route::get('/deleteEmployee/{employee}', 'EmployeeController@deleteEmployee')->name('employeess.delete');

Route::get('/deletePosition/{position}', 'PositionController@deletePosition')->name('positionss.delete');

Route::get('/deleteEducation/{education}', 'EducationController@deleteEducation')->name('educationss.delete');

Route::get('/anyData', 'BookController@anyData')->name('datatables.data');

Route::get('/adminLogout', 'Auth\LoginController@AdminLogout')->name('admin.logout');
Route::get('/memberLogout', 'Auth\LoginController@MemberLogout')->name('member.logout');

Route::get('addToCart/{book}', 'BorrowController@addToCart')->name('add.to.cart');
Route::get('clearCart/{segment}', 'BorrowController@clearCart')->name('clear.cart');
Route::get('checkout/', 'BorrowController@showCheckOut')->name('checkout.page');


//UNTUK API

Route::get('/api/books', 'ApiController@all')->name('api.all');

Route::post('/api/books/', 'ApiController@store')->name('api.store');

Route::get('/api/books/{code}', 'ApiController@show')->name('api.show');

Route::put('/api/books/{code}', 'ApiController@update')->name('api.update');

Route::delete('/api/books/{code}', 'ApiController@destroy')->name('api.destroy');
