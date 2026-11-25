@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.languagesProfil.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.languages-profils.update', [$languagesProfil->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="user_id">{{ trans('cruds.languagesProfil.fields.user') }}</label>
                        <select class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ ($languagesProfil->user ? $languagesProfil->user->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.languagesProfil.fields.user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="language_id">{{ trans('cruds.languagesProfil.fields.language') }}</label>
                        <select class="form-control {{ $errors->has('language') ? 'is-invalid' : '' }}" name="language_id" id="language_id" required>
                            @foreach($languages as $id => $language)
                                <option value="{{ $id }}" {{ ($languagesProfil->language ? $languagesProfil->language->id : old('language_id')) == $id ? 'selected' : '' }}>{{ $language }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('language'))
                            <div class="invalid-feedback">
                                {{ $errors->first('language') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.languagesProfil.fields.language_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="level">{{ trans('cruds.languagesProfil.fields.level') }}</label>
                        <input class="form-control {{ $errors->has('level') ? 'is-invalid' : '' }}" type="number" name="level" id="level" value="{{ old('level', $languagesProfil->level) }}" step="1">
                        @if($errors->has('level'))
                            <div class="invalid-feedback">
                                {{ $errors->first('level') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.languagesProfil.fields.level_helper') }}</small>
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
<small class="form-text text-muted">
@endsection