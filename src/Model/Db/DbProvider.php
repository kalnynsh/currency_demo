<?php

namespace App\Model\Db;

use App\Model\Db\CurrencyRepository;
use App\Model\Currency\Entity\Currency;

class DbProvider implements CurrencyProviderInterface
{
    /**
     * CurrencyRepository methods get from DB by ID, set to DB by ID,
     * findByDate(string $name, \DateTimeImmutable $requestDate)
     *
     * @property CurrencyRepository $currencyRepository
     */
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Find Curency object
     * by $name like 'dollarUS', \DateTimeImmutable $requestDate
     *
     * @param string $name
     * @param \DateTimeImmutable $requestDate
     * @return Currency|null
     */
    public function findCurrency(string $name, \DateTimeImmutable $requestDate): ?Currency
    {
        $currency = $this->currencyRepository->findByDate($name, $requestDate);

        if ($currency && $currency->isValidToDate($requestDate)) {
            return $currency;
        }

        return null;
    }

    /**
     * Save Currency object in DB
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

        $this->currencyRepository->add($currency);
    }
}
