@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.userFollowed.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.users-followed.update', [$userFollowed->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="user_id">{{ trans('cruds.userFollowed.fields.user') }}</label>
                        <select class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                                <option value="{{ $userFollowed->user->id }}">{{ $userFollowed->user->email }}</option>
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
                                <option value="{{ $userFollowed->follower_user->id}}">{{ $userFollowed->follower_user->email }}</option>
                        </select>
                        @if($errors->has('follower_user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('follower_user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userFollowed.fields.follower_user_helper') }}</small>
                    </div>
                    <input type="hidden" value="0" name="state">
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