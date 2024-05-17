<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class SwapRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeName = Route::currentRouteName();
        if($routeName === 'swap.data') {
            return [
                'currency_from' => ['required', 'string'],
                'currency_to' => ['required', 'string',
                    function ($attribute, $value, $fail) {
                        if ($value === $this->currency_from) {
                            $fail('The currency from and currency from must be different.');
                        }
                    }],
            ];
        }
        else{
            return [
                'amount_from' => ['required', 'numeric'],
                'currency_from' => ['required', 'string'],
                'currency_to' => ['required', 'string',
                    function ($attribute, $value, $fail) {
                        if ($value === $this->currency_from) {
                            $fail('The currency from and currency from must be different.');
                        }
                    }],
            ];
        }
    }
}
