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

    /**
     * The function `values` returns an array of values extracted from an array of objects obtained
     * from the `cases` method.
     * 
     * @return array An array of values
     */
    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
