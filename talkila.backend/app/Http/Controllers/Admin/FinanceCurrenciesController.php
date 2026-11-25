<?php

namespace App\Http\Controllers\Admin;

use App\Models\FinanceCurrency;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFinanceCurrencyRequest;
use App\Http\Requests\StoreFinanceCurrencyRequest;
use App\Http\Requests\UpdateFinanceCurrencyRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FinanceCurrenciesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('payout_currency_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $financeCurrencies = FinanceCurrency::all();

        return view('admin.financeCurrencies.index', compact('financeCurrencies'));
    }

    public function create()
    {
        abort_if(Gate::denies('payout_currency_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.financeCurrencies.create');
    }

    public function store(StoreFinanceCurrencyRequest $request)
    {
        $payoutCurrency = FinanceCurrency::create($request->all());

        return redirect()->route('admin.payout-currencies.index');
    }

    public function edit(FinanceCurrency $payoutCurrency)
    {
        abort_if(Gate::denies('payout_currency_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.financeCurrencies.edit', compact('payoutCurrency'));
    }

    public function update(UpdateFinanceCurrencyRequest $request, FinanceCurrency $payoutCurrency)
    {
        $payoutCurrency->update($request->all());

        return redirect()->route('admin.payout-currencies.index');
    }

    public function show(FinanceCurrency $payoutCurrency)
    {
        abort_if(Gate::denies('payout_currency_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payoutCurrency->load('financeCurrenciesPayouts', 'financeCurrenciesBookings', 'financeCurrenciesTalks');

        return view('admin.financeCurrencies.show', compact('payoutCurrency'));
    }

    public function destroy(FinanceCurrency $payoutCurrency)
    {
        abort_if(Gate::denies('payout_currency_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payoutCurrency->delete();

        return back();
    }

    public function massDestroy(MassDestroyFinanceCurrencyRequest $request)
    {
        FinanceCurrency::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
