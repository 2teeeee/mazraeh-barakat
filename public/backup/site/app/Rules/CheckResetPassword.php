<?php

namespace App\Rules;
use App\User;

use Illuminate\Contracts\Validation\Rule;

class CheckResetPassword implements Rule
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
        $user = User::where('codeReset',$value)->first();
                
        return ($user != null)?true:false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.attributes.notSetResetCode');
    }
}
