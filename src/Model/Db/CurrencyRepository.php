<?php

namespace App\Model\Db;

use App\Model\Currency\Entity\Currency;

class CurrencyRepository
{
    public function findByDate(string $name, \DateTimeImmutable $requestDate): ?Currency
    {
        // Need to implement
    }

    /**
     * Save Currency $currency to DB
     *
     * @param Currency $currency
     * @return void
     */
    public function add(Currency $currency): void
    {
        // Need to implement
    }
}
