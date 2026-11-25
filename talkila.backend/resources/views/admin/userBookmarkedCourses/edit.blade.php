@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.userBookmarkedTalks.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.user-bookmarked-talks.update", [$userBookmarkedTalks->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.userBookmarkedTalks.fields.user_id') }}</label>
                <input class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}" type="text" name="user_id" id="user_id" value="{{ old('user_id', $userBookmarkedTalks->user_id) }}" required>
                @if($errors->has('user_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userBookmarkedTalks.fields.user_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="talks_id">{{ trans('cruds.userBookmarkedTalks.fields.talks_id') }}</label>
                <input class="form-control {{ $errors->has('talks_id') ? 'is-invalid' : '' }}" type="text" name="talks_id" id="talks_id" value="{{ old('talks_id', $userBookmarkedTalks->talks_id) }}" required>
                @if($errors->has('talks_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('talks_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userBookmarkedTalks.fields.talks_id_helper') }}</span>
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
