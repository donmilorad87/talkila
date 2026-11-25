@extends('layout.mainlayout')
@section('content')
    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.payout.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.payout-invoices.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payout.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $payout->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payout.fields.payout_date') }}
                                    </th>
                                    <td>
                                        {{ $payout->payout_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payout.fields.price') }}
                                    </th>
                                    <td>
                                        {{ $payout->price }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payout.fields.finance_currencies') }}
                                    </th>
                                    <td>
                                        {{ $payout->finance_currencies->symbol ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payout.fields.invoice_number') }}
                                    </th>
                                    <td>
                                        {{ $payout->invoice_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payout.fields.sales_tax') }}
                                    </th>
                                    <td>
                                        {{ $payout->sales_tax }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payout.fields.reference') }}
                                    </th>
                                    <td>
                                        {{ $payout->reference }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.payout.fields.transferred_date') }}
                                    </th>
                                    <td>
                                        {{ $payout->transferred_date }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.payout-invoices.index') }}">
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
                <a class="nav-link" href="#payouts_bookings_payouts" role="tab" data-toggle="tab">
                    {{ trans('cruds.bookingsPayout.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="payouts_bookings_payouts">
                @includeIf('admin.payouts.relationships.payoutsBookingsPayouts', ['bookingsPayouts' => $payout->payoutsBookingsPayouts])
            </div>
        </div>
    </div>
@endsection
