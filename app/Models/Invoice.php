<?php

namespace App\Models;

use App\Model;

class Invoice extends Model
{


    public function create(float $amount, int $userId): int
    {
        $stmt = sprintf("INSERT INTO invoices (amount, user_id) 
                            values (%s, %s)", $amount, $userId);

        $this->db->getPdo()->query($stmt);

        return $this->db->getPdo()->lastInsertId();
    }

    public function find(int $invoiceId): array
    {
        $stmt = sprintf("SELECT invoices.id, amount, full_name 
                            FROM invoices LEFT JOIN users 
                            ON user_id = users.id WHERE invoices.id =%s", $invoiceId);
        $invoice = $this->db->getPdo()->query($stmt)->fetch();

        return $invoice ? $invoice : [];

    }
}