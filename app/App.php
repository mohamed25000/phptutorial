<?php

declare(strict_types=1);

namespace App;

use App\Exception\RouteNotFoundException;
use App\Services\EmailService;
use App\Services\InvoiceService;
use App\Services\PaymentGetwayService;
use App\Services\SalesTaxService;

class App
{
    private static DB $db;

    public static Container $container;

    public function __construct(protected Router $router,

                                protected Config $config)
    {
        static::$db = new DB($config->db ?? []);
        static::$container = new Container();
        static::$container->set(InvoiceService::class, function (Container $c) {
            return new InvoiceService(
                $c->get(EmailService::class),
                $c->get(PaymentGetwayService::class),
                $c->get(SalesTaxService::class)
            );
        });

        static::$container->set(SalesTaxService::class, fn() => new SalesTaxService());
        static::$container->set(PaymentGetwayService::class, fn() => new PaymentGetwayService());
        static::$container->set(EmailService::class, fn() => new EmailService());

    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve($this->router->path(),
                strtolower($this->router->method()));
        }catch(RouteNotFoundException) {
            http_response_code(404);
            echo View::make("error/404");
        }
    }
}