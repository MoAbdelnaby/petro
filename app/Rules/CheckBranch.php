<?php

namespace App\Rules;

use App\Models\Branch;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CheckBranch implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user_brancesids = Branch::where('active', true)->where('user_id', parentID())->pluck('id')->toArray();
        return in_array($value, $user_brancesids);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "you can't access to this branch";
    }
}
