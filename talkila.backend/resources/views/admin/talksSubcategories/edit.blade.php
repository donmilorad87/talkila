@extends('layout.mainlayout')
@section('content')

<div class="card">
    <div class="card-body">
        <div class="card-header">
            <h5>{{ trans('global.edit') }} {{ trans('cruds.talksSubcategories.title_singular') }}</h5>
        </div>
        <form method="POST" action="{{ route("admin.talk-subcategories.update", [$talksSubcategories->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="talk_categories_id">{{ trans('cruds.talksSubcategories.fields.talk_categories_id') }}</label>
                <select class="form-control {{ $errors->has('talk_categories_id') ? 'is-invalid' : '' }}" name="talk_categories_id" id="talk_categories_id" required>
                    @foreach($talks as $id => $talks_name)
                        <option value="{{ $id }}" {{ ($talksSubcategories->talk_categories_id ? $talksSubcategories->talk_categories_id : old('talk_categories_id')) == $id ? 'selected' : '' }}>{{ $talks_name }}</option>
                    @endforeach
                </select>
                @if($errors->has('talk_categories_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('talk_categories_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.talksSubcategories.fields.talk_categories_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="croatian">{{ trans('cruds.talksSubcategories.fields.croatian') }}</label>
                <input class="form-control {{ $errors->has('croatian') ? 'is-invalid' : '' }}" type="text" name="croatian" id="croatian" value="{{ old('croatian', $talksSubcategories->croatian) }}" required>
                @if($errors->has('croatian'))
                    <div class="invalid-feedback">
                        {{ $errors->first('croatian') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.talksSubcategories.fields.croatian_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="german">{{ trans('cruds.talksSubcategories.fields.german') }}</label>
                <input class="form-control {{ $errors->has('german') ? 'is-invalid' : '' }}" type="text" name="german" id="german" value="{{ old('german', $talksSubcategories->german) }}">
                @if($errors->has('german'))
                    <div class="invalid-feedback">
                        {{ $errors->first('german') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.talksSubcategories.fields.german_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="croatian">{{ trans('cruds.talksSubcategories.fields.english') }}</label>
                <input class="form-control {{ $errors->has('english') ? 'is-invalid' : '' }}" type="text" name="english" id="english" value="{{ old('english', $talksSubcategories->english) }}">
                @if($errors->has('english'))
                    <div class="invalid-feedback">
                        {{ $errors->first('english') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.talksSubcategories.fields.english_helper') }}</span>
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
