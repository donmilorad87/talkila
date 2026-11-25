@extends('layout.mainlayout')
@section('content')

<h4>{{ trans('cruds.booking.title_singular') }} {{ trans('cruds.booking.fields.id') }}: {{ $booking->id }}</h4>

<!-- Stats Card -->
<div class="row">
    <div class="col-lg-4 col-sm-4">
        <div class="stats-card-one mb-30" style="min-height: 135px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-0 fs-25">
                        {{ $booking->price }}
                        @if($booking->finance_currencies)
                            {{ $booking->finance_currencies->symbol }}
                        @endif
                    </p><br/>
                    <p class="mb-0 fs-25">{{ $booking->duration }} {{ trans('global.minutes') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-sm-4">
        <div class="stats-card-one mb-30" style="min-height: 135px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @if($booking->callsFeedback)
                    <p class="mb-0 fs-25">{{ trans('cruds.feedback.title_singular') }}</p>
                    @foreach($booking->callsFeedback as $feedback)
                    <div class="Stars" style="--rating: {{ $feedback->stars_content }};"></div><span class="mb-0 fs-20">  {{ trans('global.content') }}</span><br/>
                    <div class="Stars" style="--rating: {{ $feedback->stars_voice_quality }};"></div><span class="mb-0 fs-20">  {{ trans('global.network') }}</span>
                    @endforeach
                    @else
                    <p class="mb-0 fs-25">{{ trans('cruds.feedback.messages.no_feedback') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-sm-4">
        <div class="stats-card-one mb-30" style="min-height: 135px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @if($booking->state == 1)
                        <span class="success-color mb-0 fs-25">{{ trans('global.done') }}</span>
                    @elseif($booking->state == 2)
                        <span class="warning-color mb-0 fs-25">{{ trans('global.pending') }}</span>
                    @elseif($booking->state == 3)
                        <span class="danger-color mb-0 fs-25">{{ trans('global.cancellation') }}</span>
                    @endif
                    <p class="mb-0 fs-18">{{ trans('cruds.booking.fields.created_at') }}: {{ $booking->created_at }}</p>
                    <p class="mb-0 fs-18">{{ trans('cruds.booking.fields.meeting_at') }}: {{ $booking->start_call }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Stats Card -->

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label mb-0 fs-20"> {{ trans('global.talk_name') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $booking->talk->headline }}">
                    </div>
                    <label class="col-sm-1 col-form-label">
                        <a class="mb-0 fs-20" href="{{ route('admin.talks.show', $booking->talk_id) }}">{{ trans('global.open') }}</a>
                    </label>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label mb-0 fs-20"> {{ trans('global.client_name') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ \App\Models\User::withTrashed()->find($booking->participant_user_id)->name }}">
                    </div>
                    <label class="col-sm-1 col-form-label">
                        <a class="mb-0 fs-20" href="{{ route('admin.users.show', $booking->participant_user_id) }}">{{ trans('global.open') }}</a>
                    </label>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label mb-0 fs-20">{{ trans('global.provider_name') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $booking->teacher_user_with_trashed->name }}">
                    </div>
                    <label class="col-sm-1 col-form-label">
                        <a class="mb-0 fs-20" href="{{ route('admin.users.show', $booking->teacher_user_id) }}">{{ trans('global.open') }}</a>
                    </label>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label mb-0 fs-20">{{ trans('cruds.talk.fields.meeting_start') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $booking->start_call }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label mb-0 fs-20">{{ trans('cruds.talk.fields.meeting_end') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"  value="{{ $booking->end_call }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label mb-0 fs-20">{{ trans('cruds.talk.fields.duration') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $booking->duration }} {{ trans('global.minutes') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($booking->cancellation_reason)
<h4>{{ trans('cruds.callsCancellationReason.title_singular') }}</h4>
<p class="danger-color mb-0 fs-18">{{ $booking->cancellation_reason->english }}</p><br/>
@endif

<h4 class="card-title">{{ trans('cruds.booking.extensions') }} ({{ $extensions }})</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.booking.fields.start_call') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.booking.fields.end_call') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.fields.duration') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.fields.price') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $booking->start_call }}</td>
                                    <td>{{ $booking->end_call }}</td>
                                    <td>{{ $booking->duration }}</td>
                                    <td>{{ $booking->price }} {{ $booking->finance_currencies->symbol }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<h4 class="card-title">{{ trans('cruds.booking.call_protocol') }}</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('global.time') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('global.participient') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('global.what') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<h4 class="card-title">{{ trans('cruds.booking.billing') }}</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('global.date') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('global.topic') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('global.link') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><a href=""></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
