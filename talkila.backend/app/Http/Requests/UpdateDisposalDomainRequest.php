<?php

namespace App\Http\Requests;

use App\Models\DisposalDomain;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateDisposalDomainRequest
 * @package App\Http\Requests
 */
class UpdateDisposalDomainRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('disposal_domain_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'domain' => [
                'required',
                'max:45',
            ],
        ];
    }
}
