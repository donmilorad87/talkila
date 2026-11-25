<?php

namespace App\Http\Requests;

use App\Models\CallsCancellationReason;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreCallsCancellationReasonRequest
 * @package App\Http\Requests
 */
class StoreCallsCancellationReasonRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('calls_cancellation_reason_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'croatian' => [
                'required',
                'max:255',
            ],
            'german'   => [
                'required',
                'max:255',
            ],
            'english'  => [
                'required',
                'max:255',
            ],
            'state'    => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'type'    => [
                'required',
                'integer',
                'min:1',
                'max:4',
            ],
        ];
    }
}
