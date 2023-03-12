<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\EmailService;
use App\Services\InvoiceService;
use App\Services\PaymentGetwayService;
use App\Services\SalesTaxService;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{
    /** @test */
    public function it_process_invoice()
    {
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $paymentGetWayServiceMock = $this->createMock(PaymentGetwayService::class);
        $emailServiceMock = $this->createMock(EmailService::class);

        $paymentGetWayServiceMock->method("charge")->willReturn(true);

        $invoiceService = new InvoiceService($emailServiceMock,
                                            $paymentGetWayServiceMock,
                                            $salesTaxServiceMock);

        $customer = ["name" => "Mohamed"];
        $amount = 150;

        $result = $invoiceService->process($customer, $amount);

        $this->assertTrue($result);
    }

    /** @test */
    public function it_sends_receipt_email_when_invoice_is_processed()
    {
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $paymentGetWayServiceMock = $this->createMock(PaymentGetwayService::class);
        $emailServiceMock = $this->createMock(EmailService::class);

        $paymentGetWayServiceMock->method("charge")->willReturn(true);

        $emailServiceMock
            ->expects($this->once())
            ->method('send')
            ->with(['name' => 'Mohamed'], 'receipt');

        $invoiceService = new InvoiceService($emailServiceMock,
            $paymentGetWayServiceMock,
            $salesTaxServiceMock);

        $customer = ["name" => "Mohamed"];
        $amount = 150;

        $result = $invoiceService->process($customer, $amount);

        $this->assertTrue($result);
    }
    
}