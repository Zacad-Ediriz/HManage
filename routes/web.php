<?php
use App\Models\User;
use App\Http\Controllers\Doctor;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginContoller;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\PayBillsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\EmplooyeeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PaymentFormController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\ExpensescategoryController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleDoctorController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\PurchaseReportController;
use App\Http\Controllers\PatientBalanceReportController;
use App\Http\Controllers\VendorBalanceReportController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalaryStructureController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceReportController;
use App\Http\Controllers\SalaryGenerateController;
use App\Http\Controllers\SalaryListController;
use App\Http\Controllers\RefundController;




// Route::get('/', function () {
//     return view('welcome');
// });


Route::get("/", [LoginContoller::class, "index"])->name("login");
Route::post("/auth/login", [LoginContoller::class, "login"])->name("login");
Route::post("/", [LoginContoller::class, "logout"])->name("logout");


// Route::middleware('auth')->group(function () {
//     Route::get('/', [HomeController::class, "index"])->name('dashboard');
// });


    Route::middleware('auth')->group(function () {
    Route::get('/dashbourd', [DoctorController::class, "dashbourds"])->name('dashboards');
    Route::get('/userdashboard', [DoctorController::class, "userdashboard"])->name('userdashboard');

    Route::get('/doctor', [DoctorController::class, 'index'])->name('Doctor');
    Route::post('/doctor', [DoctorController::class, "store"])->name("Doctorstore");
    Route::get('/doctor{id}', [DoctorController::class, "edit"])->name("DoctorEdit");
    Route::post('/doctorupdate/{id}', [DoctorController::class, "update"])->name("DoctorUpdate");
    Route::get('/doctordelete/{id}', [DoctorController::class, "destroy"])->name("DoctorDelete");

    Route::get('/userss', [DoctorController::class, 'userindex'])->name('userss');
    Route::post('/userss', [DoctorController::class, "userstore"])->name("userssstore");
    Route::get('/userss{id}', [DoctorController::class, "useredit"])->name("userssEdit");
    Route::post('/userssupdate/{id}', [DoctorController::class, "userupdate"])->name("userssUpdate");
    Route::get('/userssdelete/{id}', [DoctorController::class, "userdestroy"])->name("userssDelete");

    Route::get('/transfer', [TransferController::class, 'showTransferForm'])->name('transfer.form');
    Route::post('/transfer', [TransferController::class, 'performTransfer'])->name('transfer.perform');
    
    Route::get('/reports', [ReportController::class, 'profitAndLoss'])->name('reports');

    Route::get('/doctorScheduleddd', function () {
        return 'test is working';
    })->name('doctorSchedule');
    
    

// Define a route for the sales report index
    Route::get('/sales_report', [SalesReportController::class, 'index'])->name('sales_report.index');
    Route::get('/purchase_report', [PurchaseReportController::class, 'index'])->name('sales_report.purchase');
    
   

    Route::get('/patient-balance', [PatientBalanceReportController::class, 'index'])->name('patient.patient');
    Route::get('/vendor-balance', [VendorBalanceReportController::class, 'index'])->name('vendor.vendor');
    
    Route::get('schedule', [ScheduleDoctorController::class, 'index'])->name('schedule.index');
    Route::get('schedule/create', [ScheduleDoctorController::class, 'create'])->name('schedule.create');
    Route::post('schedule', [ScheduleDoctorController::class, 'store'])->name('schedule.store');
    


    Route::get('/mydoctorSchedule', [DoctorScheduleController::class, 'index'])->name('doctorSchedule');
    Route::post('/mydoctorSchedule', [DoctorScheduleController::class, "store"])->name("doctorSchedulestore");
    Route::get('/mydoctorSchedule{id}', [DoctorScheduleController::class, "edit"])->name("doctorScheduleEdit");
    Route::post('/mydoctorScheduleupdate/{id}', [DoctorScheduleController::class, "update"])->name("doctorScheduleUpdate");
    Route::get('/mydoctorScheduledelete/{id}', [DoctorScheduleController::class, "destroy"])->name("doctorScheduleDelete");



    // Routes for emplooyee
    Route::prefix('employees')->group(function () {
        // Route to list all employees
        Route::get('/', [EmplooyeeController::class, 'index'])->name('employees.index');
       // Route::get('/{id}', [EmplooyeeController::class, 'show'])->name('employees.show');
        Route::get('/create', [EmplooyeeController::class, 'create'])->name('employees.create');
        Route::post('/', [EmplooyeeController::class, 'store'])->name('employees.store');
        Route::get('/{id}/edit', [EmplooyeeController::class, 'edit'])->name('employees.edit');
        Route::put('/{id}', [EmplooyeeController::class, 'update'])->name('employees.update');
        Route::delete('/{id}', [EmplooyeeController::class, 'destroy'])->name('employees.destroy');
    });

    // Routes for service
    Route::get('/service', [ServiceController::class, "index"])->name("service");
    Route::post('/service', [ServiceController::class, "store"])->name("serviceStore");
    Route::get('/service/{id}', [ServiceController::class, "edit"])->name("serviceEdit");
    Route::post('/service/update/{id}', [ServiceController::class, "update"])->name("serviceUpdate");
    Route::get('/service/delete/{id}', [ServiceController::class, "destroy"])->name("serviceDelete");




    // Routes for service
    Route::get('/account', [AccountController::class, "index"])->name("account");
    Route::post('/account', [AccountController::class, "store"])->name("accountStore");
    Route::get('/account/{id}', [AccountController::class, "edit"])->name("accountEdit");
    Route::post('/account/update/{id}', [AccountController::class, "update"])->name("accountUpdate");
    Route::get('/account/delete/{id}', [AccountController::class, "destroy"])->name("accountDelete");



    // Routes for service
    Route::get('/patient', [PatientController::class, "index"])->name("patient");
    Route::post('/patient', [PatientController::class, "store"])->name("patientStore");
    Route::get('/patient/{id}', [PatientController::class, "edit"])->name("patientEdit");
    Route::post('/patient/update/{id}', [PatientController::class, "update"])->name("patientUpdate");
    Route::get('/patient/delete/{id}', [PatientController::class, "destroy"])->name("patientDelete");



    Route::get('/vendor', [VendorController::class, "index"])->name("vendor");
    Route::post('/vendor', [VendorController::class, "store"])->name("vendorStore");
    Route::get('/vendor/{id}', [VendorController::class, "edit"])->name("vendorEdit");
    Route::post('/vendor/update/{id}', [VendorController::class, "update"])->name("vendorUpdate");
    Route::get('/vendor/delete/{id}', [VendorController::class, "destroy"])->name("vendorDelete");

    // Routes for service
    Route::get('/invoice', [InvoiceController::class, "index"])->name("invoice");
    Route::post('/invoice', [InvoiceController::class, "store"])->name("invoiceStore");
    Route::get('/invoice/{id}', [InvoiceController::class, "edit"])->name("invoiceEdit");
    Route::post('/invoice/update/{id}', [InvoiceController::class, "update"])->name("invoiceUpdate");
    Route::get('/invoice/delete/{id}', [InvoiceController::class, "destroy"])->name("invoiceDelete");
    Route::post('/getItem', [InvoiceController::class, "getInvoiceItem"])->name("getInvoiceItem");
    Route::post('/getpateintBalance', [InvoiceController::class, "getpateintBalance"])->name("getpateintBalance");
    Route::post('/getitemprice', [InvoiceController::class, "getitemprice"])->name("getitemprice");
    Route::post('/getSerivicePrice', [InvoiceController::class, "getSerivicePrice"])->name("getSerivicePrice");
    
    
    
    Route::get('/refund', [RefundController::class, "index"])->name("refund");
    Route::post('/refund', [RefundController::class, "store"])->name("refundStore");
    Route::get('/refund/{id}', [RefundController::class, "edit"])->name("refundEdit");
    Route::post('/refund/update/{id}', [RefundController::class, "update"])->name("refundUpdate");
    Route::get('/refund/delete/{id}', [RefundController::class, "destroy"])->name("refundDelete");
   // Route::post('/getItem', [RefundController::class, "getrefundItem"])->name("getrefundItem");
    Route::post('/getpateintBalance', [RefundController::class, "getpateintBalance"])->name("getpateintBalance");
    Route::post('/getitemprice', [RefundController::class, "getitemprice"])->name("getitemprice");
    Route::post('/getSerivicePrice', [RefundController::class, "getSerivicePrice"])->name("getSerivicePrice");
    


    Route::get('/purchase', [PurchaseController::class, "index"])->name("purchase");
    Route::post('/purchase', [PurchaseController::class, "store"])->name("purchaseStore");
    Route::get('/purchase/{id}', [PurchaseController::class, "edit"])->name("purchaseEdit");
    Route::post('/purchase/update/{id}', [PurchaseController::class, "update"])->name("purchaseUpdate");
    Route::get('/purchase/delete/{id}', [PurchaseController::class, "destroy"])->name("purchaseDelete");
    Route::post('/getItems', [PurchaseController::class, "getpurchaseItem"])->name("getpurchaseItem");
    Route::post('/getvendorsBalance', [PurchaseController::class, "getvendorsBalance"])->name("getvendorsBalance");



    Route::get('/paymentform', [PaymentFormController::class, 'index'])->name('paymentform.index');

// Route to handle the form submission (POST request)
    Route::post('/paymentform', [PaymentFormController::class, 'store'])->name('paymentform.store');
    // Route::get('/paymentform', [PaymentFormController::class, "index"])->name("paymentform");
    // Route::post('/paymentform', [PaymentFormController::class, "store"])->name("paymentformStore");
    Route::get('/paymentform/{id}', [PaymentFormController::class, "edit"])->name("paymentformEdit");
    Route::post('/paymentform/update/{id}', [PaymentFormController::class, "update"])->name("paymentformUpdate");
  
    Route::get('/paymentform/delete/{id}', [PaymentFormController::class, "destroy"])->name("paymentformDelete");
    Route::post('/getInvoiceBalance', [PaymentFormController::class, "getInvoiceBalance"])->name("getInvoiceBalance");

    Route::get('/Appointment', [AppointmentController::class, "index"])->name("appointment.index");
    //Route::post('/Appointment', [AppointmentController::class, "store"])->name("AppointmentStore");
    //Route::get('/Appointment/{id}', [AppointmentController::class, "edit"])->name("AppointmentEdit");
    //Route::post('/Appointment/update/{id}', [AppointmentController::class, "update"])->name("AppointmentUpdate");
    //Route::get('/Appointment/delete/{id}', [AppointmentController::class, "destroy"])->name("AppointmentDelete");
    //Route::post('/getdoctorTime', [AppointmentController::class, "getdoctorTime"])->name("getdoctorTime");
    Route::get('/Appointment/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/Appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointments/{date}', [AppointmentController::class, 'getAppointmentsForDate']);
    Route::get('/Appointment/create', [AppointmentController::class, "create"])->name("appointment.create");
    Route::post('/Appointments', [AppointmentController::class, "storePayment"])->name("appointment.storePayment");
    
    Route::get('/api/appointments', [AppointmentController::class, 'getAppointments']);
    Route::get('/api/appointment/{id}', [AppointmentController::class, 'getAppointmentDetails']);
    Route::get('/Appointment/{id}', [AppointmentController::class, 'show'])->name('appointment.show');
    
    // Route::get('/paybills', [PayBillsController::class, "index"])->name("paybills");
    // Route::Post('/paybills', [PayBillsController::class, "store"])->name("paybillsStore");
    Route::get('/paybills/{id}', [PayBillsController::class, "edit"])->name("paybillsEdit");
    Route::post('/paybills/update/{id}', [PayBillsController::class, "update"])->name("paybillsUpdate");
    Route::get('/paybills/delete/{id}', [PayBillsController::class, "destroy"])->name("paybillsDelete");
    Route::post('/getvendorBalance', [PayBillsController::class, "getvendorBalance"])->name("getvendorBalance");
    
    // Route::get('/paybills/create', [PayBillsController::class, 'create'])->name('paybills.create');
    // Route::post('/paybills', [PayBillsController::class, 'store'])->name('paybills.store');
    //Hrm
    // Route to display the form (GET request)
    Route::get('/paybills', [PayBillsController::class, 'index'])->name('paybills.index');

// Route to handle the form submission (POST request)
    Route::post('/paybills', [PayBillsController::class, 'store'])->name('paybills.store');
    

    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

    


    Route::get('/salary_structures', [SalaryStructureController::class, 'index'])->name('salary_structures.index');
    Route::post('/salary_structures', [SalaryStructureController::class, 'store'])->name('salary_structures.store');
    Route::get('/salary_structures/{salary_structure}/edit', [SalaryStructureController::class, 'edit'])->name('salary_structures.edit');
    Route::put('/salary_structures/{salary_structure}', [SalaryStructureController::class, 'update'])->name('salary_structures.update');
    Route::delete('/salary_structures/{salary_structure}', [SalaryStructureController::class, 'destroy'])->name('salary_structures.destroy');
    

   


    Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');
    Route::post('/positions', [PositionController::class, 'store'])->name('positions.store');
    Route::get('/positions/{position}/edit', [PositionController::class, 'edit'])->name('positions.edit');
    Route::put('/positions/{position}', [PositionController::class, 'update'])->name('positions.update');
    Route::delete('/positions/{position}', [PositionController::class, 'destroy'])->name('positions.destroy');


    

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index'); // View Attendance List
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store'); // Save Attendance
    Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy'); // Delete Attendance
    
    
    

    Route::get('/attendance-report', [AttendanceReportController::class, 'index'])->name('attendance-report.index'); // View the report
    Route::post('/attendance-report/export', [AttendanceReportController::class, 'export'])->name('attendance-report.export'); // Export options

        
        
    

    // Salary Generate Routes
    Route::prefix('salary-generate')->name('salary_generate.')->group(function () {
        // View salary generate list
        Route::get('/', [SalaryGenerateController::class, 'index'])->name('index'); 
        
        // Open form to generate salary
        Route::get('/create', [SalaryGenerateController::class, 'create'])->name('create'); 
        
        // Submit the salary generation form
        Route::post('/', [SalaryGenerateController::class, 'store'])->name('store'); 
    });
    
   

//     Route::get('/salary/generate', [SalaryGenerateController::class, 'index'])->name('salary.index');
//     Route::post('/salary/generate', [SalaryGenerateController::class, 'store'])->name('salary_generate.store');
   // Route::get('/salary/generate', [SalaryGenerateController::class, 'index']);
    //Route::post('/salary/generate', [SalaryGenerateController::class, 'store']);
    
    
  
    
    // Route::get('/salaries', [SalaryGenerateController::class, 'GG']);
    // Route::post('/salaries/{id}/pay', [SalaryGenerateController::class, 'paySalary']);
    Route::get('/accounts', [SalaryListController::class, 'getAccounts']);
    Route::get('/salaries', [SalaryListController::class, 'GG'])->name('salary.index');
    Route::post('/salaries/pay/{id}', [SalaryListController::class, 'paySalary'])->name('salary.pay');



    

    


    Route::get('/product', [ProductController::class, "index"])->name("product");
    Route::post('/product', [ProductController::class, "store"])->name("productStore");
    Route::get('/product/{id}', [ProductController::class, "edit"])->name("productEdit");
    Route::post('/product/update/{id}', [ProductController::class, "update"])->name("productUpdate");
    Route::get('/product/delete/{id}', [ProductController::class, "destroy"])->name("productDelete");


    Route::get('/expenses', [ExpensesController::class, "index"])->name("expenses");
    Route::post('/expenses', [ExpensesController::class, "store"])->name("expensesStore");
    Route::get('/expenses/{id}', [ExpensesController::class, "edit"])->name("expensesEdit");
    Route::post('/expenses/update/{id}', [ExpensesController::class, "update"])->name("expensesUpdate");
    Route::get('/expenses/delete/{id}', [ExpensesController::class, "destroy"])->name("expensesDelete");


    Route::get('/expensescategory', [ExpensescategoryController::class, "index"])->name("expensescategory");
    Route::post('/expensescategory', [ExpensescategoryController::class, "store"])->name("expensescategoryStore");
    Route::get('/expensescategory/{id}', [ExpensescategoryController::class, "edit"])->name("expensescategoryEdit");
    Route::post('/expensescategory/update/{id}', [ExpensescategoryController::class, "update"])->name("expensescategoryUpdate");
    Route::get('/expensescategory/delete/{id}', [ExpensescategoryController::class, "destroy"])->name("expensescategoryDelete");
});
include ('usermanagement.php');




route::get("/users", function () {
    User::create(
        [
            'name' => 'user',
            'email' => 'user@gmail.com',
            'type' => 'user',
            'password' => bcrypt('1234'),
        ]
    );
});