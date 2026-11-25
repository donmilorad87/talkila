@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.userFollowed.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.users-followed.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="user_id">{{ trans('cruds.userFollowed.fields.user') }}</label>
                        <select class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userFollowed.fields.user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="follower_user_id">{{ trans('cruds.userFollowed.fields.follower_user') }}</label>
                        <select class="form-control {{ $errors->has('follower_user') ? 'is-invalid' : '' }}" name="follower_user_id" id="follower_user_id" required>
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ old('follower_user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('follower_user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('follower_user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userFollowed.fields.follower_user_helper') }}</small>
                    </div>
                    <input type="hidden" value="1" name="state">
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