<?php

namespace App\Rules;

use App\Models\Application;

class HasAccessToApplication
{
    public static function passes($attribute, $value)
    {
    }
    public static function message()
    {
        return "you don't have access to application :value";
    }
}
