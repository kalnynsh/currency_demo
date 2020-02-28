<?php

namespace App\Model\Cache;

use App\Model\Currency\Entity\Currency;

class CacheProvider implements CurrencyProviderInterface
{
    /**
     * StorageEngine methods get from cache by key, set to cache by key
     *
     * @property StorageEngine $storage
     */
    private $storage;

    public function __construct($storage)
    {
        $this->storage = $storage;
    }

    /**
     * Find Curency object by key like 'currency:dollarUS:2020-02-28'
     *
     * @param string $name
     * @param \DateTimeImmutable $requestDate
     * @return Currency|null
     */
    public function findCurrency(string $name, \DateTimeImmutable $requestDate): ?Currency
    {
        $key = 'currency:' . $name . ':' . $requestDate->format('Y-m-d');
        $currency = $this->storage->get($key);

        if ($currency && $currency->isValidToDate($requestDate)) {
            return $currency;
        }

        return null;
    }

    /**
     * Storage Currency object by key like 'currency:dollarUS:2020-02-28'
     *
     * @param string $name
     * @param string $ruCourse
     * @param \DateTimeImmutable $storageDate
     * @param \DateTimeImmutable $validUntilDate
     * @return void
     */
    public function setCurrency(
        string $name,
        string $ruCourse,
        \DateTimeImmutable $storageDate,
        \DateTimeImmutable $validUntilDate
    ): void {
        $key = 'currency:' . $name . ':' . $storageDate->format('Y-m-d');

        $currency = new Currency(
            $name,
            $ruCourse,
            $storageDate,
            $validUntilDate
        );

        $this->storage->set($key, $currency);
    }
}
