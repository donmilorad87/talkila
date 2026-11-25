<?php

namespace App\Http\Requests;

use App\Models\DisposalEmail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreDisposalEmailRequest
 * @package App\Http\Requests
 */
class StoreDisposalEmailRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('disposal_email_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'max:45',
            ],
        ];
    }
}
