<?php

namespace App\Http\Requests;

use App\Models\StaticMetric;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreStaticMetricRequest
 * @package App\Http\Requests
 */
class StoreStaticMetricRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('static_metric_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'user_id'                      => [
                'required',
                'integer',
            ],
            'follower'                     => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'reviews'                      => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'talks'                        => [
                'nullable',
                'integer',
                'max:999999',
            ],
            'revenue'                      => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'bad_reports'                  => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'send_emails'                  => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'searches_per_day'             => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'visited_user_profils_per_day' => [
                'nullable',
                'integer',
                'max:9',
            ],
            'dont_show_again'              => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'visited'                      => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
