<?php

namespace App\Controller;

use App\Model\Currency\CurrencyProvider;

class CurrencyController
{
    /**
     * @property CurrencyProvider
     */
    private $currencyProvider;

    public function __construct(CurrencyProvider $currencyProvider)
    {
        $this->currencyProvider = $currencyProvider;
    }

    public function currency(
        CurrencyProvider $currencyProvider,
        $name = 'dollarUS',
        $date = null
    ) {
        if (!$date) {
            $date = new \DateTimeImmutable();
        }

        $currency = $this->currencyProvider->getCurrency($name, $date);

        // Neen to implement
        // return $this->render(...);
    }
}
