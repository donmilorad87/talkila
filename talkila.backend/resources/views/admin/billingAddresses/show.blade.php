@extends('layout.mainlayout')
@section('content')

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.billingAddress.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.billing-addresses.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.billingAddress.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $billingAddress->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.billingAddress.fields.street') }}
                                    </th>
                                    <td>
                                        {{ $billingAddress->street }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.billingAddress.fields.zipcode') }}
                                    </th>
                                    <td>
                                        {{ $billingAddress->zipcode }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.billingAddress.fields.city') }}
                                    </th>
                                    <td>
                                        {{ $billingAddress->city }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.billingAddress.fields.company_name') }}
                                    </th>
                                    <td>
                                        {{ $billingAddress->company_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.billingAddress.fields.tax_number') }}
                                    </th>
                                    <td>
                                        {{ $billingAddress->tax_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.billingAddress.fields.email') }}
                                    </th>
                                    <td>
                                        {{ $billingAddress->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.billingAddress.fields.tel_number') }}
                                    </th>
                                    <td>
                                        {{ $billingAddress->tel_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.billingAddress.fields.countries') }}
                                    </th>
                                    <td>
                                        {{ $billingAddress->countries->name ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.billing-addresses.index') }}">
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
                <a class="nav-link" href="#billing_address_talks" role="tab" data-toggle="tab">
                    {{ trans('cruds.talk.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="billing_address_talks">
                @includeIf('admin.billingAddresses.relationships.billingAddressTalks', ['talks' => $billingAddress->billingAddressTalks])
            </div>
        </div>
    </div>
@endsection
