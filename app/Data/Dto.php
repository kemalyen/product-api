<?php

namespace App\Data;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

abstract class Dto implements Arrayable, JsonSerializable
{
    abstract public function toArray();

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
