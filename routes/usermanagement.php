<?php

use App\Http\Controllers\Usermanagement\RoleController;
use App\Http\Controllers\Usermanagement\UserController;


Route::middleware('auth')->group(function () {
    Route::prefix('user_management')->name("user_management.")->group(function () {
        Route::prefix('users')->name("users.")->group(function () {
            route::get("/", [UserController::class, "index"])->name("index");
            route::post("/data", [UserController::class, "data"])->name("data");
            route::post("/company_data", [UserController::class, "company_data"])->name("company_data");
            route::post("/create", [UserController::class, "create"])->name("create");
            route::post("/getSingle", [UserController::class, "getSingle"])->name("getSingle");
            route::post("/delete", [UserController::class, "delete"])->name("delete");
            route::get("/profile", [UserController::class, "profile"])->name("profile");
            route::post("/profile", [UserController::class, "updt_prf"])->name("profile_store");
            route::post("/change", [UserController::class, "change"])->name("change");
            route::post("/hrm_details", [UserController::class, "hrm_details"])->name("hrm_details");
            route::post("/hruser", [UserController::class, "hruser"])->name("hruser");
        });
        Route::prefix('roles')->name("roles.")->group(function () {
            route::get("/", [RoleController::class, "index"])->name("index");
            route::post("/data", [RoleController::class, "data"])->name("data");
            route::post("/create", [RoleController::class, "create"])->name("create");
            route::post("/getSingle", [RoleController::class, "getSingle"])->name("getSingle");
            route::post("/delete", [RoleController::class, "delete"])->name("delete");
            route::match(["get", "post"], "/permission/{id}", [RoleController::class, "givePermission"])->name("givePermission");
        });

    });

});
