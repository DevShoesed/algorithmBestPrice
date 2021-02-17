<?php

namespace App\Model;

class Airport
{
    public int $id;
    public string $name;
    public string $code;
    public float $lat;
    public float $lng;

    public function __construct(int $id, string $name, string $code, float $lat, float $lng)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->lat = $lat;
        $this->lng = $lng;
    }
}
