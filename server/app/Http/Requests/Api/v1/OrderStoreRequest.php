<?php

namespace App\Http\Requests\Api\v1;

use App\Rules\ValidShippingMethod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderStoreRequest extends FormRequest
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
        return [
            'address_id' => [
                'required',
                Rule::exists('addresses', 'id')->where(function ($builder) {
                    $builder->where('user_id', $this->user()->id);
                })
            ],
            'payment_method_id' => [
                'required',
                Rule::exists('payment_methods', 'id')->where(function ($builder) {
                    return $builder->where('user_id', $this->user()->id);
                })
            ],
            'shipping_method_id' => ['required', new ValidShippingMethod($this->address_id)],
        ];
    }
}
