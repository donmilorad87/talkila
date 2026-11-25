@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.suggestionsHomeScreen.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.suggestions-home-screen.update", [$suggestionsHomeScreen->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.suggestionsHomeScreen.fields.user_id') }}</label>
                <input class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}" type="text" name="user_id" id="user_id" value="{{ old('user_id', $suggestionsHomeScreen->user_id) }}">
                @if($errors->has('user_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.suggestionsHomeScreen.fields.user_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="language_id">{{ trans('cruds.suggestionsHomeScreen.fields.language_id') }}</label>
                <input class="form-control {{ $errors->has('language_id') ? 'is-invalid' : '' }}" type="text" name="language_id" id="language_id" value="{{ old('language_id', $suggestionsHomeScreen->language_id) }}">
                @if($errors->has('language_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('language_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.suggestionsHomeScreen.fields.language_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="categories_id">{{ trans('cruds.suggestionsHomeScreen.fields.categories_id') }}</label>
                <input class="form-control {{ $errors->has('categories_id') ? 'is-invalid' : '' }}" type="text" name="categories_id" id="categories_id" value="{{ old('categories_id', $suggestionsHomeScreen->categories_id) }}" required>
                @if($errors->has('categories_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('categories_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.suggestionsHomeScreen.fields.categories_id_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
