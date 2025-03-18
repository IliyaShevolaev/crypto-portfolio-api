<?php

namespace App\Utilities;

class DateConvertation
{
    public static function dayMonthConvert(string $date)
    {
        $parts = explode('-', $date);

        if (count($parts) === 3) {
            return "$parts[1]-$parts[0]-$parts[2]";
        } 

        return null;
    }
}
