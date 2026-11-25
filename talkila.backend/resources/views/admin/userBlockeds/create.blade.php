@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.userBlocked.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.users-blocked.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="user_id">{{ trans('cruds.userBlocked.fields.user') }}</label>
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
                        <small class="form-text text-muted">{{ trans('cruds.userBlocked.fields.user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="blocked_user_id">{{ trans('cruds.userBlocked.fields.blocked_user') }}</label>
                        <select class="form-control {{ $errors->has('blocked_user') ? 'is-invalid' : '' }}" name="blocked_user_id" id="blocked_user_id" required>
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ old('blocked_user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('blocked_user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('blocked_user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userBlocked.fields.blocked_user_helper') }}</small>
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

@endsection