<?php
use App\Http\Controllers\Doctor;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginContoller;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\patientController;
use App\Http\Controllers\productController;
use App\Http\Controllers\serviceController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\PayBillsController;
use App\Http\Controllers\purchaseController;
use App\Http\Controllers\EmplooyeeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PaymentFormController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\expensescategoryController;


// Route::get('/', function () {
//     return view('welcome');
// });




Route::get("/auth/login", [LoginContoller::class, "index"])->name("login");
Route::post("/auth/login", [LoginContoller::class, "login"])->name("login");
Route::get("/auth/logout", [LoginContoller::class, "logout"])->name("logout");



Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, "index"])->name('dashboard');
});


Route::get('/dashbourd', [DoctorController::class, "dashbourds"])->name('dashboards');






Route::middleware('auth')->group(function () {

    Route::get('/doctor', [DoctorController::class, 'index'])->name('Doctor');
    Route::post('/doctor', [DoctorController::class, "store"])->name("Doctorstore");
    Route::get('/doctor{id}', [DoctorController::class, "edit"])->name("DoctorEdit");
    Route::post('/doctorupdate/{id}', [DoctorController::class, "update"])->name("DoctorUpdate");
    Route::get('/doctordelete/{id}', [DoctorController::class, "destroy"])->name("DoctorDelete");


    Route::get('/doctorScheduleddd', function () {
        return 'test is working';
    })->name('doctorSchedule');


    Route::get('/mydoctorSchedule', [DoctorScheduleController::class, 'index'])->name('doctorSchedule');
    Route::post('/mydoctorSchedule', [DoctorScheduleController::class, "store"])->name("doctorSchedulestore");
    Route::get('/mydoctorSchedule{id}', [DoctorScheduleController::class, "edit"])->name("doctorScheduleEdit");
    Route::post('/mydoctorScheduleupdate/{id}', [DoctorScheduleController::class, "update"])->name("doctorScheduleUpdate");
    Route::get('/mydoctorScheduledelete/{id}', [DoctorScheduleController::class, "destroy"])->name("doctorScheduleDelete");



    // Routes for emplooyee
    Route::get('/emplooyee', [EmplooyeeController::class, "index"])->name("emplooyee");
    Route::post('/emplooyee', [EmplooyeeController::class, "store"])->name("emplooyeeStore");
    Route::get('/emplooyee/{id}', [EmplooyeeController::class, "edit"])->name("emplooyeeEdit");
    Route::post('/emplooyee/update/{id}', [EmplooyeeController::class, "update"])->name("emplooyeeUpdate");
    Route::get('/emplooyee/delete/{id}', [EmplooyeeController::class, "destroy"])->name("emplooyeeDelete");


    // Routes for service
    Route::get('/service', [serviceController::class, "index"])->name("service");
    Route::post('/service', [serviceController::class, "store"])->name("serviceStore");
    Route::get('/service/{id}', [serviceController::class, "edit"])->name("serviceEdit");
    Route::post('/service/update/{id}', [serviceController::class, "update"])->name("serviceUpdate");
    Route::get('/service/delete/{id}', [serviceController::class, "destroy"])->name("serviceDelete");




    // Routes for service
    Route::get('/account', [AccountController::class, "index"])->name("account");
    Route::post('/account', [AccountController::class, "store"])->name("accountStore");
    Route::get('/account/{id}', [AccountController::class, "edit"])->name("accountEdit");
    Route::post('/account/update/{id}', [AccountController::class, "update"])->name("accountUpdate");
    Route::get('/account/delete/{id}', [AccountController::class, "destroy"])->name("accountDelete");



    // Routes for service
    Route::get('/patient', [patientController::class, "index"])->name("patient");
    Route::post('/patient', [patientController::class, "store"])->name("patientStore");
    Route::get('/patient/{id}', [patientController::class, "edit"])->name("patientEdit");
    Route::post('/patient/update/{id}', [patientController::class, "update"])->name("patientUpdate");
    Route::get('/patient/delete/{id}', [patientController::class, "destroy"])->name("patientDelete");



    Route::get('/vendor', [vendorController::class, "index"])->name("vendor");
    Route::post('/vendor', [vendorController::class, "store"])->name("vendorStore");
    Route::get('/vendor/{id}', [vendorController::class, "edit"])->name("vendorEdit");
    Route::post('/vendor/update/{id}', [vendorController::class, "update"])->name("vendorUpdate");
    Route::get('/vendor/delete/{id}', [vendorController::class, "destroy"])->name("vendorDelete");

    // Routes for service
    Route::get('/invoice', [invoiceController::class, "index"])->name("invoice");
    Route::post('/invoice', [invoiceController::class, "store"])->name("invoiceStore");
    Route::get('/invoice/{id}', [invoiceController::class, "edit"])->name("invoiceEdit");
    Route::post('/invoice/update/{id}', [invoiceController::class, "update"])->name("invoiceUpdate");
    Route::get('/invoice/delete/{id}', [invoiceController::class, "destroy"])->name("invoiceDelete");
    Route::post('/getItem', [invoiceController::class, "getInvoiceItem"])->name("getInvoiceItem");
    Route::post('/getbalances', [invoiceController::class, "getpateintBalance"])->name("getpateintBalance");
    Route::post('/getitemprices', [invoiceController::class, "getitemprice"])->name("getitemprice");
    Route::post('/getSerivicePrice', [invoiceController::class, "getSerivicePrice"])->name("getSerivicePrice");


    Route::get('/purchase', [purchaseController::class, "index"])->name("purchase");
    Route::post('/purchase', [purchaseController::class, "store"])->name("purchaseStore");
    Route::get('/purchase/{id}', [purchaseController::class, "edit"])->name("purchaseEdit");
    Route::post('/purchase/update/{id}', [purchaseController::class, "update"])->name("purchaseUpdate");
    Route::get('/purchase/delete/{id}', [purchaseController::class, "destroy"])->name("purchaseDelete");
    Route::post('/getItems', [purchaseController::class, "getpurchaseItem"])->name("getpurchaseItem");
    Route::post('/getbalance', [purchaseController::class, "getpateintBalance"])->name("getpateintBalance");

    Route::get('/paymentform', [PaymentFormController::class, "index"])->name("paymentform");
    Route::post('/paymentform', [PaymentFormController::class, "store"])->name("paymentformStore");
    Route::get('/paymentform/{id}', [PaymentFormController::class, "edit"])->name("paymentformEdit");
    Route::post('/paymentform/update/{id}', [PaymentFormController::class, "update"])->name("paymentformUpdate");
    Route::get('/paymentform/delete/{id}', [PaymentFormController::class, "destroy"])->name("paymentformDelete");
    Route::post('/getInvoiceBalance', [PaymentFormController::class, "getInvoiceBalance"])->name("getInvoiceBalance");

    Route::get('/Appointment', [AppointmentController::class, "index"])->name("Appointment");
    Route::post('/Appointment', [AppointmentController::class, "store"])->name("AppointmentStore");
    Route::get('/Appointment/{id}', [AppointmentController::class, "edit"])->name("AppointmentEdit");
    Route::post('/Appointment/update/{id}', [AppointmentController::class, "update"])->name("AppointmentUpdate");
    Route::get('/Appointment/delete/{id}', [AppointmentController::class, "destroy"])->name("AppointmentDelete");
    Route::post('/getdoctorTime', [AppointmentController::class, "getdoctorTime"])->name("getdoctorTime");

    Route::get('/paybills', [PayBillsController::class, "index"])->name("paybills");
    Route::Post('/paybills', [PayBillsController::class, "store"])->name("paybillsStore");
    Route::get('/paybills/{id}', [PayBillsController::class, "edit"])->name("paybillsEdit");
    Route::post('/paybills/update/{id}', [PayBillsController::class, "update"])->name("paybillsUpdate");
    Route::get('/paybills/delete/{id}', [PayBillsController::class, "destroy"])->name("paybillsDelete");
    Route::post('/getvendorBalance', [PayBillsController::class, "getvendorBalance"])->name("getvendorBalance");


    Route::get('/product', [productController::class, "index"])->name("product");
    Route::post('/product', [productController::class, "store"])->name("productStore");
    Route::get('/product/{id}', [productController::class, "edit"])->name("productEdit");
    Route::post('/product/update/{id}', [productController::class, "update"])->name("productUpdate");
    Route::get('/product/delete/{id}', [productController::class, "destroy"])->name("productDelete");


    Route::get('/expenses', [ExpensesController::class, "index"])->name("expenses");
    Route::post('/expenses', [ExpensesController::class, "store"])->name("expensesStore");
    Route::get('/expenses/{id}', [ExpensesController::class, "edit"])->name("expensesEdit");
    Route::post('/expenses/update/{id}', [ExpensesController::class, "update"])->name("expensesUpdate");
    Route::get('/expenses/delete/{id}', [ExpensesController::class, "destroy"])->name("expensesDelete");


    Route::get('/expensescategory', [expensescategoryController::class, "index"])->name("expensescategory");
    Route::post('/expensescategory', [expensescategoryController::class, "store"])->name("expensescategoryStore");
    Route::get('/expensescategory/{id}', [expensescategoryController::class, "edit"])->name("expensescategoryEdit");
    Route::post('/expensescategory/update/{id}', [expensescategoryController::class, "update"])->name("expensescategoryUpdate");
    Route::get('/expensescategory/delete/{id}', [expensescategoryController::class, "destroy"])->name("expensescategoryDelete");
});
include ('usermanagement.php');