<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\ReglementCheque;

class UniqueChequeId implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the selected cheque_id is unique among ReglementCheque records
        return ReglementCheque::where('cheque_id', $value)
            ->where('id', '!=', request()->route('id')) // Exclude the current record being updated
            ->doesntExist();
    }

    public function message()
    {
        return 'The selected cheque has already been used in another ReglementCheque record.';
    }
}