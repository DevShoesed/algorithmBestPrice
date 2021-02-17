<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Airport;

class AirportRepository
{

    private $data = [];
    /**
     * Return a List of all Airport
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * Set Data
     * @param Airport[] $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
