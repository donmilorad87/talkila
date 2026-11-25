@extends('layout.mainlayout')
@section('content')

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.search.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.searches.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.search.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $search->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.search.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $search->user->email ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.search.fields.term') }}
                                    </th>
                                    <td>
                                        {{ $search->term }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.searches.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Data Table -->
@endsection