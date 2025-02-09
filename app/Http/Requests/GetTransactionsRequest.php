<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetTransactionsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:200'],
            'sort'   => ['nullable', 'string', Rule::in(['transaction_date', 'description', 'amount'])],
            'order'  => ['nullable', 'string', Rule::in(['asc', 'desc'])],
        ];
    }

    public function getFilter(): array
    {
        $validated = $this->validated();

        return [
            'user_id' => auth()->id(),
            'search'  => $validated['search'] ?? null,
            'sort'    => $validated['sort'] ?? 'transaction_date',
            'order'   => $validated['order'] ?? 'desc',
        ];
    }
}
