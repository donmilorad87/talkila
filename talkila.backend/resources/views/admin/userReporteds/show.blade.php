@extends('layout.mainlayout')
@section('content')

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.userReported.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.user-reporteds.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userReported.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $userReported->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userReported.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $userReported->user->email ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userReported.fields.reporter_user') }}
                                    </th>
                                    <td>
                                        {{ $userReported->reporter_user->email ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userReported.fields.description') }}
                                    </th>
                                    <td>
                                        {{ $userReported->description }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userReported.fields.state') }}
                                    </th>
                                    <td>
                                        {{ $userReported->state }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.user-reporteds.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Data Table -->
@endsection