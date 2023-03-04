<?php

namespace Src\Core\Services;

class StringService
{
    public static function moneyFormat(float $money)
    {
        return number_format($money, 2, ",", ".");
    }
}
