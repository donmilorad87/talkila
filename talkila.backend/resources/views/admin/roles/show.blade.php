@extends('layout.mainlayout') 
@section('content')

<!-- Data Table -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.role.title') }}</h5>
                </div>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.roles.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table m-0 table-hover">
                        <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.role.fields.id') }}
                                </th>
                                <td>
                                    {{ $role->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.role.fields.title') }}
                                </th>
                                <td>
                                    {{ $role->title }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.role.fields.permissions') }}
                                </th>
                                <td>
                                    @foreach($role->permissions as $key => $permissions)
                                        <span class="label label-info">{{ $permissions->title }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.roles.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Data Table -->
@endsection