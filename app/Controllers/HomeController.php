<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\DB;
use App\Models\Invoice;
use App\Models\SignUp;
use App\Models\User;
use App\Services\InvoiceService;
use App\View;

class HomeController
{
    public function index(): View
    {
        App::$container->get(InvoiceService::class)->process([], 25);

        $db = App::db();

        /*$email = "mohamedMENNOUR02050@outlook.fr";
        $name = "MOHAMED MOHAMED";
        $amount = 25;

        $userModel = new User();
        $invoiceModel = new Invoice();

        $invoiceId = (new SignUp($userModel, $invoiceModel))->register(
            [
                "email" => $email,
                "name" => $name,
            ],
            [
                "amount" => $amount,
            ]
        );*/

        /*try {
            $db->beginTransaction();

            $userId = $userModel->create($email, $name, true);
            $invoiceId = $invoiceModel->create($amount, $userId);

            $db->commit();

        } catch (\Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw $e;
        }*/
        /*$fetchStmt = sprintf("SELECT invoices.id AS invoice_id,
                            amount, user_id, full_name 
                            FROM invoices INNER JOIN users 
                            ON user_id = users.id WHERE email='%s'", $email);

        echo "<pre>";
        var_dump($fetchStmt);
        echo "</pre>";*/
        ///** @var array $fetchStmt */
        /*foreach ($db->getPdo()->query($fetchStmt) as $row) {

            echo "<pre>";
            var_dump($row);
            echo "</pre>";
        }*/

        //return View::make("index", ['invoice' => $invoiceModel->find($invoiceId)]);
        return View::make("index");
    }
}









    /* public function download()
    {
        header('Content-type: application/pdf');
        header('Content-disposition: attachement;filename="myfile.pdf"');

        readfile(STORAGE_PATH . "/receipt 11-23-2022.pdf");
    }

    public function upload()
    {
        $filePath = STORAGE_PATH . "/" . $_FILES["receipt"]["name"];
        move_uploaded_file($_FILES["receipt"]["tmp_name"], $filePath);

        header("Location: /");

        exit;
    }*/
