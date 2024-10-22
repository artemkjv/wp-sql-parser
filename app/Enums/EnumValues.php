<?php

namespace App\Enums;

trait EnumValues
{

    public static function values() {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }
        return $values;
    }

    public static function keys() {
        $keys = [];
        foreach (self::cases() as $case) {
            $keys[] = $case->key;
        }
        return $keys;
    }

}
