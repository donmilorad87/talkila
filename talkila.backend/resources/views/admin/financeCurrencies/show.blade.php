@extends('layout.mainlayout')
@section('content')

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.payoutCurrency.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.payout-currencies.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payoutCurrency.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $payoutCurrency->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payoutCurrency.fields.iso_code') }}
                                    </th>
                                    <td>
                                        {{ $payoutCurrency->iso_code }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payoutCurrency.fields.short_code') }}
                                    </th>
                                    <td>
                                        {{ $payoutCurrency->short_code }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payoutCurrency.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $payoutCurrency->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payoutCurrency.fields.value') }}
                                    </th>
                                    <td>
                                        {{ $payoutCurrency->value }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payoutCurrency.fields.symbol') }}
                                    </th>
                                    <td>
                                        {{ $payoutCurrency->symbol }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.payout-currencies.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Data Table -->
    <div class="card-body">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#finance_currencies_payouts" role="tab" data-toggle="tab">
                    {{ trans('cruds.payout.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#finance_currencies_bookings" role="tab" data-toggle="tab">
                    {{ trans('cruds.booking.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#finance_currencies_talks" role="tab" data-toggle="tab">
                    {{ trans('cruds.talk.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="finance_currencies_payouts">
                @includeIf('admin.financeCurrencies.relationships.financeCurrenciesPayouts', ['payouts' => $payoutCurrency->financeCurrenciesPayouts])
            </div>
            <div class="tab-pane" role="tabpanel" id="finance_currencies_bookings">
                @includeIf('admin.financeCurrencies.relationships.financeCurrenciesBookings', ['bookings' => $payoutCurrency->financeCurrenciesBookings])
            </div>
            <div class="tab-pane" role="tabpanel" id="finance_currencies_talks">
                @includeIf('admin.financeCurrencies.relationships.financeCurrenciesTalks', ['talks' => $payoutCurrency->financeCurrenciesTalks])
            </div>
        </div>
    </div>

@endsection
