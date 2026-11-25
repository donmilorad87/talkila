<?php

namespace App\Http\Requests;

use App\Models\DisposalDomain;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroyDisposalDomainRequest
 * @package App\Http\Requests
 */
class MassDestroyDisposalDomainRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('disposal_domain_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:disposal_domains,id',
        ];
    }
}
