@extends('layout.mainlayout')
@section('content')

<!-- Vertical Form -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.role.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.roles.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('cruds.role.fields.title') }}</label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                        @if($errors->has('title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.role.fields.title_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="permissions">{{ trans('cruds.role.fields.permissions') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control {{ $errors->has('permissions') ? 'is-invalid' : '' }}" name="permissions[]" id="permissions" multiple required>
                            @foreach($permissions as $id => $permissions)
                                <option value="{{ $id }}" {{ in_array($id, old('permissions', [])) ? 'selected' : '' }}>{{ $permissions }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('permissions'))
                            <div class="invalid-feedback">
                                {{ $errors->first('permissions') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.role.fields.permissions_helper') }}</small>
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
<!-- End Vertical Form -->
@endsection