@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.country.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.countries.update', [$country->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="short_code">{{ trans('cruds.country.fields.short_code') }}</label>
                        <input class="form-control {{ $errors->has('short_code') ? 'is-invalid' : '' }}" type="text" name="short_code" id="short_code" value="{{ old('short_code', $country->short_code) }}" required>
                        @if($errors->has('short_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('short_code') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.country.fields.short_code_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="german">{{ trans('cruds.country.fields.german') }}</label>
                        <input class="form-control {{ $errors->has('german') ? 'is-invalid' : '' }}" type="text" name="german" id="german" value="{{ old('german', $country->german) }}">
                        @if($errors->has('german'))
                            <div class="invalid-feedback">
                                {{ $errors->first('german') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.country.fields.german_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="english">{{ trans('cruds.country.fields.english') }}</label>
                        <input class="form-control {{ $errors->has('english') ? 'is-invalid' : '' }}" type="text" name="english" id="english" value="{{ old('english', $country->english) }}" required>
                        @if($errors->has('english'))
                            <div class="invalid-feedback">
                                {{ $errors->first('english') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.country.fields.name_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="croatian">{{ trans('cruds.country.fields.croatian') }}</label>
                        <input class="form-control {{ $errors->has('croatian') ? 'is-invalid' : '' }}" type="text" name="croatian" id="croatian" value="{{ old('croatian', $country->croatian) }}">
                        @if($errors->has('croatian'))
                            <div class="invalid-feedback">
                                {{ $errors->first('croatian') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.country.fields.croatian_helper') }}</small>
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