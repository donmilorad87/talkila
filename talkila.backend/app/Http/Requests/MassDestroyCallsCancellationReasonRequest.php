<?php

namespace App\Http\Requests;

use App\Models\CallsCancellationReason;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroyCallsCancellationReasonRequest
 * @package App\Http\Requests
 */
class MassDestroyCallsCancellationReasonRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('calls_cancellation_reason_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:calls_cancellation_reasons,id',
        ];
    }
}
