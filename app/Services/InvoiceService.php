<?php

declare(strict_types=1);

namespace App\Services;

class InvoiceService
{
    public function __construct(protected EmailService $emailService,
                                protected PaymentGetwayService $paymentGetWayService,
                                protected SalesTaxService $salesTaxService)
    {
    }

    public function process(array $customer, float $amount): bool
    {
        /*$emailService = new EmailService();
        $paymentGetWayService = new PaymentGetwayService();
        $salesTaxService = new SalesTaxService();*/

        $tax = $this->salesTaxService->calculate($amount, $customer);

        if(! $this->paymentGetWayService->charge($customer, $amount, $tax)) {
            return false;
        }

        $this->emailService->send($customer, "receipt");
        echo "invoice processed</br>";
        return true;
    }
}