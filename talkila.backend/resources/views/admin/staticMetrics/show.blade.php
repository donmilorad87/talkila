@extends('layout.mainlayout')
@section('content')

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.staticMetric.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.static-metrics.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticMetric.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $staticMetric->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticMetric.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $staticMetric->user->email ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticMetric.fields.follower') }}
                                    </th>
                                    <td>
                                        {{ $staticMetric->follower }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticMetric.fields.reviews') }}
                                    </th>
                                    <td>
                                        {{ $staticMetric->reviews }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticMetric.fields.talks') }}
                                    </th>
                                    <td>
                                        {{ $staticMetric->talks }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticMetric.fields.revenue') }}
                                    </th>
                                    <td>
                                        {{ $staticMetric->revenue }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticMetric.fields.bad_reports') }}
                                    </th>
                                    <td>
                                        {{ $staticMetric->bad_reports }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticMetric.fields.send_emails') }}
                                    </th>
                                    <td>
                                        {{ $staticMetric->send_emails }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticMetric.fields.searches_per_day') }}
                                    </th>
                                    <td>
                                        {{ $staticMetric->searches_per_day }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticMetric.fields.visited_user_profils_per_day') }}
                                    </th>
                                    <td>
                                        {{ $staticMetric->visited_user_profils_per_day }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticMetric.fields.dont_show_again') }}
                                    </th>
                                    <td>
                                        {{ $staticMetric->dont_show_again }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticMetric.fields.visited') }}
                                    </th>
                                    <td>
                                        {{ $staticMetric->visited }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.static-metrics.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Data Table -->
@endsection
