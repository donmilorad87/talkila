@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.disposalDomain.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.disposal-domains.update', [$disposalDomain->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="domain">{{ trans('cruds.disposalDomain.fields.domain') }}</label>
                        <input class="form-control {{ $errors->has('domain') ? 'is-invalid' : '' }}" type="text" name="domain" id="domain" value="{{ old('domain', $disposalDomain->domain) }}" required>
                        @if($errors->has('domain'))
                            <div class="invalid-feedback">
                                {{ $errors->first('domain') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.disposalDomain.fields.domain_helper') }}</small>
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