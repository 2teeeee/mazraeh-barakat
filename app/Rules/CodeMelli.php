<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CodeMelli implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $x = strlen($value);
        $y = 10 - $x;
        while($y > 0)
        {
            $y--;
            $value = '0'.$value;
        }
        $sum = 0;
        $j = 10;
        for($i=0; $i<9; $i++)
        {
            $v = substr($value, $i,1);
            $sum += $j * $v;
            $j--;
        }
        $mod = $sum % 11;
        $ch = substr($value, 9,1);
        if($mod < 2)
            return ($ch == $mod)?true:false;
        else
            return ($ch == (11 - $mod))?true:false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'کد ملی وارد شده اشتباه می باشد';
    }
}
