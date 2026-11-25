@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.staticProfession.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.static-professions.update', [$staticProfession->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="croatian">{{ trans('cruds.staticProfession.fields.croatian') }}</label>
                        <input class="form-control {{ $errors->has('croatian') ? 'is-invalid' : '' }}" type="text" name="croatian" id="croatian" value="{{ old('croatian', $staticProfession->croatian) }}" required>
                        @if($errors->has('croatian'))
                            <div class="invalid-feedback">
                                {{ $errors->first('croatian') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticProfession.fields.croatian_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="german">{{ trans('cruds.staticProfession.fields.german') }}</label>
                        <input class="form-control {{ $errors->has('german') ? 'is-invalid' : '' }}" type="text" name="german" id="german" value="{{ old('german', $staticProfession->german) }}" required>
                        @if($errors->has('german'))
                            <div class="invalid-feedback">
                                {{ $errors->first('german') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticProfession.fields.german_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="english">{{ trans('cruds.staticProfession.fields.english') }}</label>
                        <input class="form-control {{ $errors->has('english') ? 'is-invalid' : '' }}" type="text" name="english" id="english" value="{{ old('english', $staticProfession->english) }}" required>
                        @if($errors->has('english'))
                            <div class="invalid-feedback">
                                {{ $errors->first('english') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticProfession.fields.english_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="spanish">{{ trans('cruds.staticProfession.fields.spanish') }}</label>
                        <input class="form-control {{ $errors->has('spanish') ? 'is-invalid' : '' }}" type="text" name="spanish" id="spanish" value="{{ old('spanish', $staticProfession->spanish) }}" required>
                        @if($errors->has('spanish'))
                            <div class="invalid-feedback">
                                {{ $errors->first('spanish') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticProfession.fields.spanish_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="french">{{ trans('cruds.staticProfession.fields.french') }}</label>
                        <input class="form-control {{ $errors->has('french') ? 'is-invalid' : '' }}" type="text" name="french" id="french" value="{{ old('french', $staticProfession->french) }}" required>
                        @if($errors->has('french'))
                            <div class="invalid-feedback">
                                {{ $errors->first('french') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticProfession.fields.french_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="italien">{{ trans('cruds.staticProfession.fields.italien') }}</label>
                        <input class="form-control {{ $errors->has('italien') ? 'is-invalid' : '' }}" type="text" name="italien" id="italien" value="{{ old('italien', $staticProfession->italien) }}">
                        @if($errors->has('italien'))
                            <div class="invalid-feedback">
                                {{ $errors->first('italien') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticProfession.fields.italien_helper') }}</small>
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