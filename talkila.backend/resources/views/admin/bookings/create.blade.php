@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.bookings.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="state">{{ trans('cruds.booking.fields.state') }}</label>
                        <select class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state" id="state">
                            <option value="0" {{ old('state') == 0 ? 'selected' : '' }}> Coming</option>
                            <option value="1" {{ old('state') == 1 ? 'selected' : '' }}> Past </option>
                            <option value="2" {{ old('state') == 2 ? 'selected' : '' }}> Cancellation </option>
                        </select>
                        @if($errors->has('state'))
                            <div class="invalid-feedback">
                                {{ $errors->first('state') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.state_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="talk_id">{{ trans('cruds.booking.fields.talk') }}</label>
                        <select class="form-control {{ $errors->has('talk_id') ? 'is-invalid' : '' }}" name="talk_id" id="talk_id">
                            @foreach($talks as $id => $talk)
                                <option value="{{ $id }}" {{ old('talk_id') == $id ? 'selected' : '' }}>{{ $talk }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('talk_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('talk_id') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.talk_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="extension">{{ trans('cruds.booking.fields.extension') }}</label>
                        <select class="form-control {{ $errors->has('booking_type') ? 'is-invalid' : '' }}" name="extension" id="extension">
                                <option value="0" {{ old('booking_type') == 0 ? 'selected' : '' }}> Normal call</option>
                                <option value="1" {{ old('booking_type') == 1 ? 'selected' : '' }}> Extension </option>
                        </select>
                        @if($errors->has('booking_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('booking_type') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.extension_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="anonym">{{ trans('cruds.booking.fields.anonym') }}</label>
                        <select class="form-control {{ $errors->has('anonym') ? 'is-invalid' : '' }}" name="anonym" id="anonym">
                                <option value="0" {{ old('anonym') == 0 ? 'selected' : '' }}> no</option>
                                <option value="1" {{ old('anonym') == 1 ? 'selected' : '' }}> yes </option>
                        </select>
                        @if($errors->has('anonym'))
                            <div class="invalid-feedback">
                                {{ $errors->first('anonym') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.anonym_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="teacher_user_id">{{ trans('cruds.booking.fields.participant_teacher') }}</label>
                        <select class="form-control {{ $errors->has('teacher_user_id') ? 'is-invalid' : '' }}" name="teacher_user_id" id="teacher_user_id">
                            @foreach($participant_users as $id => $teacher_user)
                                <option value="{{ $id }}" {{ old('teacher_user_id') == $id ? 'selected' : '' }}>{{ $teacher_user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('teacher_user_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('teacher_user_id') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.participant_teacher_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="participant_user_id">{{ trans('cruds.booking.fields.participant_user') }}</label>
                        <select class="form-control {{ $errors->has('participant_user') ? 'is-invalid' : '' }}" name="participant_user_id" id="participant_user_id">
                            @foreach($participant_users as $id => $participant_user)
                                <option value="{{ $id }}" {{ old('participant_user_id') == $id ? 'selected' : '' }}>{{ $participant_user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('participant_user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('participant_user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.participant_user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="start_call">{{ trans('cruds.booking.fields.start_call') }}</label>
                        <input class="form-control {{ $errors->has('start_call') ? 'is-invalid' : '' }}" type="text" name="start_call" id="start_call" value="{{ old('start_call') }}">
                        @if($errors->has('start_call'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_call') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.start_call_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="end_call">{{ trans('cruds.booking.fields.end_call') }}</label>
                        <input class="form-control datetime {{ $errors->has('end_call') ? 'is-invalid' : '' }}" type="text" name="end_call" id="end_call" value="{{ old('end_call') }}">
                        @if($errors->has('end_call'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_call') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.end_call_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="duration">{{ trans('cruds.booking.fields.duration') }}</label>
                        <select class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" name="duration" id="duration">
                                <option value="15" {{ old('duration') == 15 ? 'selected' : '' }}> 15</option>
                                <option value="30" {{ old('duration') == 30 ? 'selected' : '' }}> 30 </option>
                                <option value="45" {{ old('duration') == 45 ? 'selected' : '' }}> 45 </option>
                                <option value="60" {{ old('duration') == 60 ? 'selected' : '' }}> 60 </option>
                        </select>
                        @if($errors->has('duration'))
                            <div class="invalid-feedback">
                                {{ $errors->first('duration') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.duration_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="price">{{ trans('cruds.booking.fields.price') }}</label>
                        <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '') }}" step="0.01">
                        @if($errors->has('price'))
                            <div class="invalid-feedback">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.price_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="currency">{{ trans('cruds.booking.fields.finance_currencies') }}</label>
                        <select class="form-control {{ $errors->has('finance_currencies') ? 'is-invalid' : '' }}" name="currency" id="currency">
                            @foreach($finance_currencies as $id => $finance_currencies)
                                <option value="{{ $id }}" {{ old('currency') == $id ? 'selected' : '' }}>{{ $finance_currencies }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('finance_currencies'))
                            <div class="invalid-feedback">
                                {{ $errors->first('finance_currencies') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.finance_currencies_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="message">{{ trans('cruds.booking.fields.message') }}</label>
                        <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message">{{ old('message') }}</textarea>
                        @if($errors->has('message'))
                            <div class="invalid-feedback">
                                {{ $errors->first('message') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.message_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="cancellation_reason_id">{{ trans('cruds.booking.fields.cancellation_reason') }}</label>
                        <select class="form-control {{ $errors->has('cancellation_reason') ? 'is-invalid' : '' }}" name="cancellation_reason_id" id="cancellation_reason_id">
                            @foreach($cancellation_reasons as $id => $cancellation_reason)
                                <option value="{{ $id }}" {{ old('cancellation_reason_id') == $id ? 'selected' : '' }}>{{ $cancellation_reason }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('cancellation_reason'))
                            <div class="invalid-feedback">
                                {{ $errors->first('cancellation_reason') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.booking.fields.cancellation_reason_helper') }}</small>
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
@section('scripts')
@parent
<script type="text/javascript">
$(function () {
    $('#start_call').datetimepicker({
        format: 'YYYY-MM-DD hh:mm:ss'
    });
});
$(function () {
    $('#end_call').datetimepicker({
        format: 'YYYY-MM-DD hh:mm:ss'
    });
});
</script>
@endsection
