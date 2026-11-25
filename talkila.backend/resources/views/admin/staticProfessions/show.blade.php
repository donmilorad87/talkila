@extends('layout.mainlayout')
@section('content')

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.staticProfession.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.static-professions.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticProfession.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $staticProfession->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticProfession.fields.croatian') }}
                                    </th>
                                    <td>
                                        {{ $staticProfession->croatian }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticProfession.fields.german') }}
                                    </th>
                                    <td>
                                        {{ $staticProfession->german }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticProfession.fields.english') }}
                                    </th>
                                    <td>
                                        {{ $staticProfession->english }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticProfession.fields.spanish') }}
                                    </th>
                                    <td>
                                        {{ $staticProfession->spanish }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticProfession.fields.french') }}
                                    </th>
                                    <td>
                                        {{ $staticProfession->french }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.staticProfession.fields.italien') }}
                                    </th>
                                    <td>
                                        {{ $staticProfession->italien }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.static-professions.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Data Table -->
    <div class="card-body">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#profession_profil_cvs" role="tab" data-toggle="tab">
                    {{ trans('cruds.profilCv.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="profession_profil_cvs">
                @includeIf('admin.staticProfessions.relationships.professionProfilCvs', ['profilCvs' => $staticProfession->professionProfilCvs])
            </div>
        </div>
    </div>

@endsection