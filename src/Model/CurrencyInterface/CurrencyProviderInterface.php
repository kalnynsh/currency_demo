<?php

namespace App\Model\CurrencyInterface;

use App\Model\Currency\Entity\Currency;

interface CurrencyProviderInterface
{
    public function findCurrency(string $name, \DateTimeImmutable $requestDate): ?Currency;
    public function setCurrency(string $name, \DateTimeImmutable $setDate): void;
}
