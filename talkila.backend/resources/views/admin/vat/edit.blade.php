@extends('layout.mainlayout')
@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.vat.title_singular') }}</h5>
                    </div>

                    <form method="POST" action="{{ route('admin.vat.update', $vat->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="english">{{ trans('cruds.vat.fields.english') }}</label>
                            <input class="form-control {{ $errors->has('english') ? 'is-invalid' : '' }}" type="text" name="english" id="english" value="{{ old('english', $vat->english) }}" required>
                            @if($errors->has('english'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('english') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.vat.fields.english_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="german">{{ trans('cruds.vat.fields.german') }}</label>
                            <input class="form-control {{ $errors->has('german') ? 'is-invalid' : '' }}" type="text" name="german" id="german" value="{{ old('german', $vat->german) }}">
                            @if($errors->has('german'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('german') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.vat.fields.german_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="croatian">{{ trans('cruds.vat.fields.croatian') }}</label>
                            <input class="form-control {{ $errors->has('croatian') ? 'is-invalid' : '' }}" type="text" name="croatian" id="croatian" value="{{ old('croatian', $vat->croatian) }}">
                            @if($errors->has('croatian'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('croatian') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.vat.fields.croatian_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <label class="required" for="country_code">{{ trans('cruds.vat.fields.country_code') }}</label>
                            <input class="form-control {{ $errors->has('country_code') ? 'is-invalid' : '' }}" type="text" name="country_code" id="country_code" value="{{ old('country_code', $vat->country_code) }}" required>
                            <input type="hidden" name="old_country_code" id="old_country_code" value="{{ $vat->country_code }}" required>
                            @if($errors->has('country_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('country_code') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.vat.fields.country_code_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <label class="required" for="value">{{ trans('cruds.vat.fields.value') }}</label>
                            <input class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" type="text" name="value" id="value" value="{{ old('value', $vat->value) }}" required>
                            @if($errors->has('value'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('value') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.vat.fields.value_helper') }}</small>
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