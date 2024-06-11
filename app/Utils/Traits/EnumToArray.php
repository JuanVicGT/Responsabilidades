<?php

namespace App\Utils\Traits;

trait EnumToArray
{
    /**
     * Creates an array of associative arrays containing name, title, and value
     * 
     * The diference between cases() and array() is that array() include the title that is translated
     */
    public static function array(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[] = ['name' => $case->name, 'title' => __($case->name), 'value' => $case->value];
        }
        return $array;
    }
}
