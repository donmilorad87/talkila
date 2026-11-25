@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.userReported.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.user-reporteds.update', [$userReported->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="user_id">{{ trans('cruds.userReported.fields.user') }}</label>
                        <select class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                            <option value="{{ $userReported->user->id }}">{{ $userReported->user->email }}</option>
                        </select>
                        @if($errors->has('user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userReported.fields.user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="reporter_user_id">{{ trans('cruds.userReported.fields.reporter_user') }}</label>
                        <select class="form-control {{ $errors->has('reporter_user') ? 'is-invalid' : '' }}" name="reporter_user_id" id="reporter_user_id">
                                <option value="{{ $userReported->reporter_user->id }}">{{ $userReported->reporter_user->email }}</option>
                        </select>
                        @if($errors->has('reporter_user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('reporter_user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userReported.fields.reporter_user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="type_id">{{ trans('cruds.user.fields.type') }}</label>
                        <select class="form-control {{ $errors->has('type_id') ? 'is-invalid' : '' }}" name="type_id" id="type_id">
                            <option value="1" {{ old('gender') == 1 || $userReported->type_id == 1 ? 'selected' : '' }}>SPAM</option>
                            <option value="2" {{ old('gender') == 2 || $userReported->type_id == 2 ? 'selected' : '' }}>TBD</option>
                            <option value="3" {{ old('gender') == 3 || $userReported->type_id == 3 ? 'selected' : '' }}>TBD</option>
                            <option value="4" {{ old('gender') == 4 || $userReported->type_id == 4 ? 'selected' : '' }}>TBD</option>
                            <option value="5" {{ old('gender') == 5 || $userReported->type_id == 5 ? 'selected' : '' }}>TBD</option>
                            <option value="6" {{ old('gender') == 6 || $userReported->type_id == 6 ? 'selected' : '' }}>TBD</option>
                            <option value="7" {{ old('gender') == 7 || $userReported->type_id == 7 ? 'selected' : '' }}>TBD</option>
                            <option value="8" {{ old('gender') == 8 || $userReported->type_id == 8 ? 'selected' : '' }}>TBD</option>
                            <option value="9" {{ old('gender') == 9 || $userReported->type_id == 9 ? 'selected' : '' }}>TBD</option>
                        </select>
                        @if($errors->has('type_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('type_id') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.notification_sound_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="description">{{ trans('cruds.userReported.fields.description') }}</label>
                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $userReported->description) }}</textarea>
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userReported.fields.description_helper') }}</small>
                    </div>
                    <input type="hidden" name="state" value="0">
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