<?php
// Module routes (place into Laravel routes files or include dynamically)

// Example route:
// Route::get('/admin/customers', [\Modules\Customer\Http\Controllers\CustomerController::class, 'index']);


//use Illuminate.Support\Facades\Route;

// ریدایرکت کردن صفحه اصلی به صفحه مشتریان
Route::get('/', function () {
    return redirect('/customers');
});

// نمایش لیست مشتریان
Route::get('/customers', function () {
    // این کد ویوی 'index' را از همان نام 'customer' که در مرحله 1 تعریف کردیم، بارگذاری می‌کند
    return view('customer::index');
});
