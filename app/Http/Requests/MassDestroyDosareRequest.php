<?php

namespace App\Http\Requests;

use App\Models\Dosare;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDosareRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('dosare_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:dosares,id',
        ];
    }
}
