<?php

namespace App\Http\Requests;

use App\Models\Dosare;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDosareRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dosare_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'first_name' => [
                'string',
                'required',
            ],
            'email_id' => [
                'required',
                'integer',
            ],
            'company_name' => [
                'string',
                'nullable',
            ],
            'cui' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'incident_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'asig_paper' => [
                'required',
            ],
            'aditional_files' => [
                'array',
            ],
            'aditional_photos' => [
                'array',
            ],
        ];
    }
}
