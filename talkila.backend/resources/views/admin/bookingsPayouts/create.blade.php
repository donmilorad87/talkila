@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.bookingsPayout.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.bookings-payout-invoices.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="payouts_id">{{ trans('cruds.bookingsPayout.fields.payouts') }}</label>
                        <select class="form-control {{ $errors->has('payouts') ? 'is-invalid' : '' }}" name="payouts_id" id="payouts_id" required>
                            @foreach($payouts as $id => $payouts)
                                <option value="{{ $id }}" {{ old('payouts_id') == $id ? 'selected' : '' }}>{{ $payouts }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('payouts'))
                            <div class="invalid-feedback">
                                {{ $errors->first('payouts') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.bookingsPayout.fields.payouts_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="bookings_id">{{ trans('cruds.bookingsPayout.fields.calls') }}</label>
                        <select class="form-control {{ $errors->has('calls') ? 'is-invalid' : '' }}" name="bookings_id" id="bookings_id" required>
                            @foreach($calls as $id => $calls)
                                <option value="{{ $id }}" {{ old('bookings_id') == $id ? 'selected' : '' }}>{{ $calls }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('calls'))
                            <div class="invalid-feedback">
                                {{ $errors->first('calls') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.bookingsPayout.fields.calls_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
