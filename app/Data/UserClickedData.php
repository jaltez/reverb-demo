<?php

namespace App\Data;

class UserClickedData
{
    public function __construct(
        public string $username,
        public string $color,
        public int $x,
        public int $y,
    ) {
    }
}
