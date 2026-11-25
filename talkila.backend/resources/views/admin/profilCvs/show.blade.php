@extends('layout.mainlayout')
@section('content')
    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.profilCv.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.profile-cvs.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.profilCv.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $profilCv->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.profilCv.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $profilCv->user->email ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.profilCv.fields.type') }}
                                    </th>
                                    <td>
                                        {{ $profilCv->type }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.profilCv.fields.start_date') }}
                                    </th>
                                    <td>
                                        {{ $profilCv->start_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.profilCv.fields.end_date') }}
                                    </th>
                                    <td>
                                        {{ $profilCv->end_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.profilCv.fields.company_name') }}
                                    </th>
                                    <td>
                                        {{ $profilCv->company_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.profilCv.fields.profession') }}
                                    </th>
                                    <td>
                                        {{ $profilCv->profession->english ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.profile-cvs.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Data Table -->
@endsection