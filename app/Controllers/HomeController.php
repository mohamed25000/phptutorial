<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\DB;
use App\View;

class HomeController
{
    public function index(): View
    {
        $db = App::db();
        $email = "mennour2500@gmail.com";
        $name = "mohamed";
        $amount = 25;

        try {

            $db->beginTransaction();
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $newUserStmt = $db->prepare("INSERT INTO users
                                (email, full_name, is_active, created_at)
                                values (?, ?, 1, NOW())");

            echo "<pre>";
            var_dump($newUserStmt);
            echo "</pre>";
            $newUserStmt->execute([$email, $name]);

            $userId = (int)$db->lastInsertId();

            $newInvoiceStmt = $db->prepare("INSERT INTO invoices
                                    (amount, user_id) 
                                    values (?, ?)");

            $newInvoiceStmt->execute([$amount, $userId]);
            $db->commit();

        } catch (\Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw $e;
        }
        $fetchStmt = $db->prepare("SELECT invoices.id AS invoice_id, amount, user_id, full_name
                            FROM invoices
                            INNER JOIN users ON user_id = users.id
                            WHERE email=?");

        $fetchStmt->execute([$email]);

        echo "<pre>";
        var_dump($fetchStmt->fetch(\PDO::FETCH_ASSOC));
        echo "</pre>";

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
