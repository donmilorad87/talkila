@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.language.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.languages.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="code">{{ trans('cruds.language.fields.code') }}</label>
                        <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}" required>
                        @if($errors->has('code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.language.fields.code_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="order_by">{{ trans('cruds.language.fields.order_by') }}</label>
                        <input class="form-control {{ $errors->has('order_by') ? 'is-invalid' : '' }}" type="number" name="order_by" id="order_by" value="{{ old('order_by', '') }}">
                        @if($errors->has('order_by'))
                            <div class="invalid-feedback">
                                {{ $errors->first('order_by') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.language.fields.order_by_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="croatian">{{ trans('cruds.language.fields.croatian') }}</label>
                        <input class="form-control {{ $errors->has('croatian') ? 'is-invalid' : '' }}" type="text" name="croatian" id="croatian" value="{{ old('croatian', '') }}" required>
                        @if($errors->has('croatian'))
                            <div class="invalid-feedback">
                                {{ $errors->first('croatian') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.language.fields.croatian_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="english">{{ trans('cruds.language.fields.english') }}</label>
                        <input class="form-control {{ $errors->has('english') ? 'is-invalid' : '' }}" type="text" name="english" id="english" value="{{ old('english', '') }}" required>
                        @if($errors->has('english'))
                            <div class="invalid-feedback">
                                {{ $errors->first('english') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.language.fields.english_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="german">{{ trans('cruds.language.fields.german') }}</label>
                        <input class="form-control {{ $errors->has('german') ? 'is-invalid' : '' }}" type="text" name="german" id="german" value="{{ old('german', '') }}" required>
                        @if($errors->has('german'))
                            <div class="invalid-feedback">
                                {{ $errors->first('german') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.language.fields.german_helper') }}</small>
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
