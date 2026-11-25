@extends('layout.mainlayout')
@section('content')

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.userVisited.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.user-visiteds.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userVisited.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $userVisited->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userVisited.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $userVisited->user->email ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userVisited.fields.visited_user') }}
                                    </th>
                                    <td>
                                        {{ $userVisited->visited_user->email ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.user-visiteds.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Data Table -->
@endsection