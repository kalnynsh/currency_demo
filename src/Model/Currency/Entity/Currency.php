<?php

namespace App\Model\Currency\Entity;

class Currency
{
    /* @property string $name */
    public $name;

    /* @property string $ruCourse */
    public $ruCourse;

    /* @property \DateTimeImmutable $storageDate */
    public $storageDate;

    /* @property \DateTimeImmutable $validUntilDate */
    public $validUntilDate;

    public function __construct(
        string $name,
        string $ruCourse,
        \DateTimeImmutable $storageDate,
        \DateTimeImmutable $validUntilDate = null
    ) {
        $this->name = $name;
        $this->ruCourse = $ruCourse;
        $this->storageDate = $storageDate;
        $this->validUntilDate = $validUntilDate ?: $storageDate->add(new \DateInterval('P1d'));
    }

    public function isValidToDate(\DateTimeImmutable $requestDate): bool
    {
        return $this->validUntilDate >= $requestDate;
    }

    /**
     * Convert ruCourse from string to double
     *
     * @return double
     */
    public function getRuCourse()
    {
        return (double)$this->ruCourse;
    }
}
