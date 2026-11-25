@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.userDontShowAgain.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.user-dont-show-against.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="user_id">{{ trans('cruds.userDontShowAgain.fields.user') }}</label>
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
                        <small class="form-text text-muted">{{ trans('cruds.userDontShowAgain.fields.user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="dont_show_again_user_id">{{ trans('cruds.userDontShowAgain.fields.dont_show_again_user') }}</label>
                        <select class="form-control {{ $errors->has('dont_show_again_user') ? 'is-invalid' : '' }}" name="dont_show_again_user_id" id="dont_show_again_user_id" required>
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ old('dont_show_again_user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('dont_show_again_user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('dont_show_again_user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userDontShowAgain.fields.dont_show_again_user_helper') }}</small>
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