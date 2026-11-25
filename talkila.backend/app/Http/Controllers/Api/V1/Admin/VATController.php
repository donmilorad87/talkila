<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VATController extends Controller
{
    // public VAT $vat;
    //
    // public function __construct()
    // {
    //     $this->vat = new Vat();
    // }
    //
    // public function index()
    // {
    //     return response()->success([
    //         'message' => 'List of all VAT entries.',
    //         'data'    => $this->vat->getAll(),
    //     ]);
    // }

    public function index(Request $request)
    {
        $only_vat = $request->has('only_vat') ? $request->boolean('only_vat') : true;

        $countries = Country::query()
            ->when($only_vat, function ($query) {
                $query->whereNotNull('vat_value');
            })
            ->get([
                'id',
                userLanguage() . ' as country',
                'shorter_code as country_code',
                'vat_value as value',
            ]);

        $response = response()->success([
            'message' => 'List of all VAT entries.',
            'data'    => $countries,
        ]);

        Log::notice("\n\n" . '::VATController::index::$response');
        Log::notice($response);

        return $response;
    }
}
