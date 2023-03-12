<?php

declare(strict_types=1);

namespace Tests\DataProviders;

class RouterDataProviders
{
    public static function routeNotFoundCases(): array
    {
        return [
            ['users', 'put'],
            ['invoices', 'post'],
            ['users', 'get'],
            ['users', 'post'],
        ];
    }
}