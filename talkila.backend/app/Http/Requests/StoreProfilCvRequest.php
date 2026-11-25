<?php

namespace App\Http\Requests;

use App\Models\ProfilCv;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreProfilCvRequest
 * @package App\Http\Requests
 */
class StoreProfilCvRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('profil_cv_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'user_id'       => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'type'       => [
                'nullable',
                'integer',
                'max:9',
            ],
            'start_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'end_date'   => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'company_name'   => [
                'nullable',
                'max:40',
            ],
            'profession'   => [
                'nullable',
                'max:40',
            ],
            'profession_id'   => [
                'nullable',
                'integer',
            ],
            'location'   => [
                'nullable',
                'max:100',
            ],
            'work_here'   => [
                'nullable',
                'integer',
            ],
        ];
    }
}
