@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.userVisited.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.user-visiteds.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">{{ trans('cruds.userVisited.fields.user') }}</label>
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
                        <small class="form-text text-muted">{{ trans('cruds.userVisited.fields.user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="visited_user_id">{{ trans('cruds.userVisited.fields.visited_user') }}</label>
                        <select class="form-control {{ $errors->has('visited_user') ? 'is-invalid' : '' }}" name="visited_user_id" id="visited_user_id">
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ old('visited_user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('visited_user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('visited_user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userVisited.fields.visited_user_helper') }}</small>
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