@extends('layout.mainlayout')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.search.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.searches.update', [$search->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="user_id">{{ trans('cruds.search.fields.user') }}</label>
                        <select class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ ($search->user ? $search->user->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.search.fields.user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="term">{{ trans('cruds.search.fields.term') }}</label>
                        <input class="form-control {{ $errors->has('term') ? 'is-invalid' : '' }}" type="text" name="term" id="term" value="{{ old('term', $search->term) }}" required>
                        @if($errors->has('term'))
                            <div class="invalid-feedback">
                                {{ $errors->first('term') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.search.fields.term_helper') }}</small>
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