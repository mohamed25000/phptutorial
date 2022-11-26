<?php

use App\App;
use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use App\Router;
use App\Config;


require_once __DIR__ . "/../vendor/autoload.php";

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    define(constant_name: 'STORAGE_PATH', value: __DIR__ . '/../storage');
    define(constant_name: 'VIEW_PATH', value: __DIR__ . '/../views');

    $router = new Router();

    $router
        ->get("/", action: [HomeController::class, "index"])
        ->get("/download", action: [HomeController::class, "download"])
        ->post("/upload", action: [HomeController::class, "upload"])
        ->get("/invoices", action: [InvoiceController::class, "index"])
        ->get("/invoices/create", action: [InvoiceController::class, "create"])
        ->post("/invoices/create", action: [InvoiceController::class, "store"]);

(new App(
    $router,
    request: ["uri" => $_SERVER["REQUEST_URI"], "method" => $_SERVER["REQUEST_METHOD"]],
    config: new Config($_ENV) ))
    ->run();




