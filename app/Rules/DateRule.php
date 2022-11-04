<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class DateRule implements Rule
{
    protected $date;

    protected $comparator;

    /**
     * Create a new rule instance.
     * 
     * @return void
     */
    public function __construct($date, $comparator = '=')
    {
        $this->date = $date;
        $this->comparator = $comparator;
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
        $date1 = $this->date;
        $date2 = $value;
        switch ($this->comparator) {
            case '=':
                return $date1 == $date2;

            case '<':
                return $date1 < $date2;

            case '<=':
                return $date1 <= $date2;

            case '>':
                return $date1 > $date2;

            case '>=':
                return $date1 >= $date2;

            default:
                return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $message = '';
        // dd($this->comparator);
        Log::info('Comparator dari file DateRule ',  ['comparator' => $this->comparator]);
        switch ($this->comparator) {
            case '=':
                $message = 'Tanggal tidak sama dengan ' . $this->date;
                break;

            case '<':
                $message = 'Tanggal melebihi ' . $this->date;
                break;

            case '<=':
                $message = 'Tanggal melebihi ' . $this->date;
                break;

            case '>':
                $message = 'Tanggal berada sebelum ' . $this->date;
                break;

            case '>=':
                $message = 'Tanggal berada sebelum ' . $this->date;
                break;

            default:
                $message = 'Komparator tidak terdaftar ' . $this->comparator;
        }

        return $message;
    }
}
