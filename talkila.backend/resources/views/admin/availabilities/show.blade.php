@extends('layout.mainlayout')
@section('content')

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.availability.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.availabilities.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.availability.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $availability->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.availability.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $availability->user->email ?? '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        {{ trans('cruds.availability.fields.state') }}
                                    </th>
                                    <td>
                                        {{ $availability->state }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.availability.fields.start_time') }}
                                    </th>
                                    <td>
                                        {{ $availability->start_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.availability.fields.end_time') }}
                                    </th>
                                    <td>
                                        {{ $availability->end_time }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.availabilities.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Data Table -->
@endsection
