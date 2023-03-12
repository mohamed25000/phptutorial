<?php

namespace App\Models;

use App\Model;

class SignUp extends Model
{

    /**
     * @param User $userModel
     * @param Invoice $invoiceModel
     */
    public function __construct(protected User $userModel, protected Invoice $invoiceModel)
    {
        parent::__construct();
    }

    public function register(array $userInfo, array $invoiceInfo):int
    {
        try {
            $this->db->getPdo()->beginTransaction();

            $userId = $this->userModel->create($userInfo["email"], $userInfo["name"]);
            $invoiceId = $this->invoiceModel->create($invoiceInfo["amount"], $userId);

            $this->db->getPdo()->commit();

        } catch (\Throwable $e) {
            if ($this->db->getPdo()->inTransaction()) {
                $this->db->getPdo()->rollBack();
            }
            throw $e;
        }

        return $invoiceId;
    }
}