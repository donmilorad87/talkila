@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.userReportType.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.user-report-types.update', [$userReportType->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ trans('cruds.userReportType.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $userReportType->name) }}">
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userReportType.fields.name_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="croatian">{{ trans('cruds.userReportType.fields.croatian') }}</label>
                        <input class="form-control {{ $errors->has('croatian') ? 'is-invalid' : '' }}" type="text" name="croatian" id="croatian" value="{{ old('croatian', $userReportType->croatian) }}">
                        @if($errors->has('croatian'))
                            <div class="invalid-feedback">
                                {{ $errors->first('croatian') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userReportType.fields.croatian_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="english">{{ trans('cruds.userReportType.fields.english') }}</label>
                        <input class="form-control {{ $errors->has('english') ? 'is-invalid' : '' }}" type="text" name="english" id="english" value="{{ old('english', $userReportType->english) }}">
                        @if($errors->has('english'))
                            <div class="invalid-feedback">
                                {{ $errors->first('english') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userReportType.fields.english_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="german">{{ trans('cruds.userReportType.fields.german') }}</label>
                        <input class="form-control {{ $errors->has('german') ? 'is-invalid' : '' }}" type="text" name="german" id="german" value="{{ old('german', $userReportType->german) }}">
                        @if($errors->has('german'))
                            <div class="invalid-feedback">
                                {{ $errors->first('german') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.userReportType.fields.german_helper') }}</small>
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