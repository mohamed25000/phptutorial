<?php

namespace App\Models;

use App\Model;

class User extends Model
{


    public function create(string $email, string $name, bool $is_active = true): int
    {
        $stmt = sprintf("INSERT INTO users (email, full_name, is_active, created_at) 
                            values ('%s', '%s', '%s', NOW())", $email, $name, $is_active);
        $this->db->getPdo()->query($stmt);

        return (int) $this->db->getPdo()->lastInsertId();

    }
}