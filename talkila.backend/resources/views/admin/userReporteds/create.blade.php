@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.userReported.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.user-reporteds.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">{{ trans('cruds.userReported.fields.user') }}</label>
                        <select class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
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
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ old('reporter_user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
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
                            <option value="1" {{ old('notification_sound') == 1 ? 'selected' : '' }}>SPAM</option>
                            <option value="" {{ old('notification_sound') == 2 ? 'selected' : '' }}>TBD</option>
                            <option value="3" {{ old('notification_sound') == 3 ? 'selected' : '' }}>TBD</option>
                            <option value="4" {{ old('notification_sound') == 4 ? 'selected' : '' }}>TBD</option>
                            <option value="5" {{ old('notification_sound') == 5 ? 'selected' : '' }}>TBD</option>
                            <option value="6" {{ old('notification_sound') == 6 ? 'selected' : '' }}>TBD</option>
                            <option value="7" {{ old('notification_sound') == 7 ? 'selected' : '' }}>TBD</option>
                            <option value="8" {{ old('notification_sound') == 8 ? 'selected' : '' }}>TBD</option>
                            <option value="9" {{ old('notification_sound') == 9 ? 'selected' : '' }}>TBD</option>
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
                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userReported.fields.description_helper') }}</small>
                    </div>
                    <input type="hidden" name="state" value="1">
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