<?php

namespace App\Model\Currency;

use App\Model\Db\DbProvider;
use App\Model\Cache\CacheProvider;
use App\Model\Currency\Entity\Currency;
use App\Model\ForeignSource\ForeignSourceProvider;
use App\CurrencyInterface\CurrencyProviderInterface;

class CurrencyProvider implements CurrencyProviderInterface
{
    private $cacheProvider;
    private $dbProvider;
    private $scrProvider;

    public function __construct(
        CacheProvider $cacheProvider,
        DbProvider $dbProvider,
        ForeignSourceProvider $scrProvider
    ) {
        $this->cacheProvider = $cacheProvider;
        $this->dbProvider = $dbProvider;
        $this->scrProvider = $scrProvider;
    }

    public function getCurrency(string $name, \DateTimeImmutable $requestDate): Currency
    {
        /** @var Currency $currency */
        if ($currency = $this->cacheProvider->findCurrency($name, $requestDate)) {
            return $currency;
        }

        /** @var Currency $currency */
        if ($currency = $this->dbProvider->findCurrency($name, $requestDate)) {
            $this->setCurrencyToCache($currency);

            return $currency;
        }

        /** @var Currency $currency */
        if ($currency = $this->scrProvider->getCurrencyCourse($name, $requestDate)) {
            $this->setCurrency($currency);

            return $currency;
        }

        // May be. throw new \DomainException('Invalid request');
    }

    private function setCurrencyToCache(Currency $currency): void
    {
        $this->cacheProvider->setCurrency(
            $currency->name,
            $currency->ruCourse,
            $currency->storageDate,
            $currency->validUntilDate
        );
    }

    private function setCurrency(Currency $currency): void
    {
        $this->dbProvider->setCurrency(
            $currency->name,
            $currency->ruCourse,
            $currency->storageDate,
            $currency->validUntilDate
        );

        $this->setCurrencyToCache($currency);
    }
}
