@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.profilCv.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.profile-cvs.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">{{ trans('cruds.profilCv.fields.user') }}</label>
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
                        <small class="form-text text-muted">{{ trans('cruds.profilCv.fields.user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="type">{{ trans('cruds.profilCv.fields.type') }}</label>
                        <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="number" name="type" id="type" value="{{ old('type', '') }}" step="1">
                        @if($errors->has('type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('type') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.profilCv.fields.type_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="start_date">{{ trans('cruds.profilCv.fields.start_date') }}</label>
                        <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date') }}">
                        @if($errors->has('start_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_date') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.profilCv.fields.start_date_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="end_date">{{ trans('cruds.profilCv.fields.end_date') }}</label>
                        <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text" name="end_date" id="end_date" value="{{ old('end_date') }}">
                        @if($errors->has('end_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_date') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.profilCv.fields.end_date_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="company_name">{{ trans('cruds.profilCv.fields.company_name') }}</label>
                        <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', '') }}">
                        @if($errors->has('company_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('company_name') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.profilCv.fields.company_name_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="profession_id">{{ trans('cruds.profilCv.fields.profession') }}</label>
                        <select class="form-control {{ $errors->has('profession') ? 'is-invalid' : '' }}" name="profession_id" id="profession_id">
                            @foreach($professions as $id => $profession)
                                <option value="{{ $id }}" {{ old('profession_id') == $id ? 'selected' : '' }}>{{ $profession }}</small>
                            @endforeach
                        </select>
                        @if($errors->has('profession'))
                            <div class="invalid-feedback">
                                {{ $errors->first('profession') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.profilCv.fields.profession_helper') }}</small>
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