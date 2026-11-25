@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.callsCancellationReason.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.calls-cancellation-reasons.update', [$callsCancellationReason->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="croatian">{{ trans('cruds.callsCancellationReason.fields.croatian') }}</label>
                        <input class="form-control {{ $errors->has('croatian') ? 'is-invalid' : '' }}" type="text" name="croatian" id="croatian" value="{{ old('croatian', $callsCancellationReason->croatian) }}" required>
                        @if($errors->has('croatian'))
                            <div class="invalid-feedback">
                                {{ $errors->first('croatian') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.callsCancellationReason.fields.croatian_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="german">{{ trans('cruds.callsCancellationReason.fields.german') }}</label>
                        <input class="form-control {{ $errors->has('german') ? 'is-invalid' : '' }}" type="text" name="german" id="german" value="{{ old('german', $callsCancellationReason->german) }}" required>
                        @if($errors->has('german'))
                            <div class="invalid-feedback">
                                {{ $errors->first('german') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.callsCancellationReason.fields.german_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="english">{{ trans('cruds.callsCancellationReason.fields.english') }}</label>
                        <input class="form-control {{ $errors->has('english') ? 'is-invalid' : '' }}" type="text" name="english" id="english" value="{{ old('english', $callsCancellationReason->english) }}" required>
                        @if($errors->has('english'))
                            <div class="invalid-feedback">
                                {{ $errors->first('english') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.callsCancellationReason.fields.english_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="state">{{ trans('cruds.callsCancellationReason.fields.state') }}</label>
                        <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="number" name="state" id="state" value="{{ old('state', $callsCancellationReason->state) }}" step="1">
                        @if($errors->has('state'))
                            <div class="invalid-feedback">
                                {{ $errors->first('state') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.callsCancellationReason.fields.state_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="type">{{ trans('cruds.booking.fields.type') }}</label>
                        <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                            <option value="1" {{ ($callsCancellationReason->type ? $callsCancellationReason->type : old('anonym')) ==  1 ? 'selected' : '' }}> Client </option>
                            <option value="3" {{ ($callsCancellationReason->type ? $callsCancellationReason->type : old('anonym')) ==  3 ? 'selected' : '' }}> Active talk client </option>
                            <option value="1" {{ ($callsCancellationReason->type ? $callsCancellationReason->type : old('anonym')) ==  1 ? 'selected' : '' }}> Supplier </option>
                            <option value="4" {{ ($callsCancellationReason->type ? $callsCancellationReason->type : old('anonym')) ==  4 ? 'selected' : '' }}> Active talk supplier </option>
                        </select>
                        @if($errors->has('type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('type') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.callsCancellationReason.fields.type_helper') }}</small>
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
<small class="form-text text-muted">{{ trans('cruds.permission.fields.title_helper') }}</small>
@endsection
