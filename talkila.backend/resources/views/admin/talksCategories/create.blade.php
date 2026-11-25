@extends('layout.mainlayout')
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                {{ trans('global.create') }} {{ trans('cruds.talksCategories.title_singular') }}
            </div>
            <form method="POST" action="{{ route("admin.talk-categories.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="type">{{ trans('cruds.talksCategories.fields.croatian') }}</label>
                    <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="croatian" id="croatian" value="{{ old('croatian', '') }}">
                    @if($errors->has('croatian'))
                        <div class="invalid-feedback">
                            {{ $errors->first('croatian') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.talksCategories.fields.croatian_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="language">{{ trans('cruds.talksCategories.fields.german') }}</label>
                    <input class="form-control {{ $errors->has('german') ? 'is-invalid' : '' }}" type="text" name="german" id="german" value="{{ old('german', '') }}">
                    @if($errors->has('german'))
                        <div class="invalid-feedback">
                            {{ $errors->first('german') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.talksCategories.fields.german_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="category">{{ trans('cruds.talksCategories.fields.english') }}</label>
                    <input class="form-control {{ $errors->has('english') ? 'is-invalid' : '' }}" type="text" name="english" id="english" value="{{ old('english', '') }}" required>
                    @if($errors->has('english'))
                        <div class="invalid-feedback">
                            {{ $errors->first('english') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.talksCategories.fields.english_helper') }}</span>
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
