<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ElectronicsPhaseRule implements Rule
{
    public function passes($attribute, $value)
{
    $usageDomain = request()->input('UsageDomain');

    if ($usageDomain === 'Electronics') {
        $phases = is_array($value) ? $value : [$value];

        return in_array('Prototyping', $phases) || in_array('Testing', $phases);
    }

    return true;
}

    public function message()
    {
        return 'Electronics equipment must support Prototyping or Testing.';
    }
}
