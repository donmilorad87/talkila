@extends('layout.mainlayout')
@section('content')

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.profilPayoutMethod.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.profile-payout-methods.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.profilPayoutMethod.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $profilPayoutMethod->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.profilPayoutMethod.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $profilPayoutMethod->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.profilPayoutMethod.fields.method') }}
                                    </th>
                                    <td>
                                        {{ $profilPayoutMethod->method }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.profilPayoutMethod.fields.value') }}
                                    </th>
                                    <td>
                                        {{ $profilPayoutMethod->value }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.profilPayoutMethod.fields.state') }}
                                    </th>
                                    <td>
                                        {{ $profilPayoutMethod->state }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.profile-payout-methods.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Data Table -->
@endsection