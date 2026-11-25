@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.systemLogin.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.system-logins.update', [$systemLogin->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="user_id">{{ trans('cruds.systemLogin.fields.user') }}</label>
                        <select class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ ($systemLogin->user ? $systemLogin->user->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.systemLogin.fields.user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="login_type">{{ trans('cruds.systemLogin.fields.login_type') }}</label>
                        <input class="form-control {{ $errors->has('login_type') ? 'is-invalid' : '' }}" type="number" name="login_type" id="login_type" value="{{ old('login_type', $systemLogin->login_type) }}" step="1" required>
                        @if($errors->has('login_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('login_type') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.systemLogin.fields.login_type_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="type">{{ trans('cruds.systemLogin.fields.type') }}</label>
                        <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="number" name="type" id="type" value="{{ old('type', $systemLogin->type) }}" step="1" required>
                        @if($errors->has('type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('type') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.systemLogin.fields.type_helper') }}</small>
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