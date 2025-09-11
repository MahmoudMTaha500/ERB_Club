<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|in:credit_card,debit_card,paypal,bank_transfer'
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Product ID is required',
            'product_id.exists' => 'Selected product does not exist',
            'quantity.required' => 'Quantity is required',
            'quantity.min' => 'Quantity must be at least 1',
            'quantity.max' => 'Quantity cannot exceed 100',
            'amount.required' => 'Amount is required',
            'amount.min' => 'Amount must be greater than 0',
            'payment_method.required' => 'Payment method is required',
            'payment_method.in' => 'Invalid payment method selected'
        ];
    }
}