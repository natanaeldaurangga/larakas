<?php

namespace App\Rules;

use App\Models\Piutang;
use App\Models\Utang;
use Illuminate\Contracts\Validation\Rule;

class SaldoRule implements Rule
{

    protected $id;

    protected $jenis;

    /**
     * Create a new rule instance. 
     *
     * @return void
     */
    public function __construct($id, $jenis)
    {
        $this->jenis = $jenis;
        $this->id = $id;
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
        if ($this->jenis === 'piutang') {
            return $value <= Piutang::saldoPiutang($this->id);
        } else if ($this->jenis === 'utang') {
            return $value <= Utang::saldoUtang($this->id); // TODO: buat ini untuk validasi saldo piutang. 
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message. 
     *
     * @return string
     */
    public function message()
    {   // jadi nggak bener si validasinya gara gara pake $this->jenis 
        return 'Jumlah yang dibayarkan melebihi saldo ' . $this->jenis;
    }
}
