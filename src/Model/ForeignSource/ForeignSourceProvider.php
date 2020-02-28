<?php

namespace App\Model\ForeignSource;

use App\Model\Currency\Entity\Currency;

class ForeignSourceProvider
{
    /**
     * ForeignSourceService with methods:
     *   getCurrencyCourse(string $name,\DateTimeImmutable $date)
     *
     * @property ForeignSourceService $resource
     */
    private $resource;

    public function __construct(ForeignSourceService $resource)
    {
        $this->resource = $resource;
    }

    public function getCurrencyCourse(
        string $name,
        \DateTimeImmutable $date
    ): Currency {
        /**
         * $this->resource->getCurrencyCourse($name, $date)
         * return ForeignSourceView object
         */
        $currencyView = $this->resource->getCurrencyCourse($name, $date);

        return new Currency(
            $currencyView->currencyName,
            $currencyView->currencyRuCourse,
            $currencyView->date,
            $currencyView->date->add(new \DateInterval('P1d'))
        );
    }
}
