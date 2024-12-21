<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = $this->method();
        
        if ($method == 'PUT') {
            return [
                'customerId' => ['required'],
                'amount' => ['required', 'numeric'],
                'status' => ['required', Rule::in(['B','P','V'])],
                'billedDate' => ['required'],
                'paidDate' => ['required'],
            ];
        } else {
            return [
                'customerId' => ['sometimes','required'],
                'amount' => ['sometimes','required', 'numeric'],
                'status' => ['sometimes','required', Rule::in(['B','P','V'])],
                'billedDate' => ['sometimes','required'],
                'paidDate' => ['sometimes','required'],
            ];
        }
    }
    protected function prepareForValidation()
    {
        if ($this->customerId && $this->billedDate && $this->paidDate) {
            $this->merge([
                'customer_id' => $this->customerId,
                'billed_date' => $this->billedDate,
                'paid_date' => $this->paidDate,
            ]);
        }
    }
}
