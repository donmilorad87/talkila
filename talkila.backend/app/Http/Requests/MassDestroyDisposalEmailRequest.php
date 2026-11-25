<?php

namespace App\Http\Requests;

use App\Models\DisposalEmail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroyDisposalEmailRequest
 * @package App\Http\Requests
 */
class MassDestroyDisposalEmailRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('disposal_email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:disposal_emails,id',
        ];
    }
}
