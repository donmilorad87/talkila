@extends('layout.mainlayout')
@section('content')

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.callsCancellationReason.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.calls-cancellation-reasons.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.callsCancellationReason.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $callsCancellationReason->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.callsCancellationReason.fields.croatian') }}
                                    </th>
                                    <td>
                                        {{ $callsCancellationReason->croatian }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.callsCancellationReason.fields.german') }}
                                    </th>
                                    <td>
                                        {{ $callsCancellationReason->german }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.callsCancellationReason.fields.english') }}
                                    </th>
                                    <td>
                                        {{ $callsCancellationReason->english }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.callsCancellationReason.fields.state') }}
                                    </th>
                                    <td>
                                        {{ $callsCancellationReason->state }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.calls-cancellation-reasons.index') }}">
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
                <a class="nav-link" href="#cancellation_reason_bookings" role="tab" data-toggle="tab">
                    {{ trans('cruds.booking.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="cancellation_reason_bookings">
                @includeIf('admin.callsCancellationReasons.relationships.cancellationReasonBookings', ['bookings' => $callsCancellationReason->cancellationReasonBookings])
            </div>
        </div>
    </div>
@endsection