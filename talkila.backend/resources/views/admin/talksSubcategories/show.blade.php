@extends('layout.mainlayout')
@section('content')

<div class="card">
    <div class="card-body">
        <div class="card-header">
            <h5>{{ trans('global.show') }} {{ trans('cruds.talksSubcategories.title') }}</h5>
        </div>
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.talk-subcategories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.id') }}
                        </th>
                        <td>
                            {{ $talkSubcategories->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.german') }}
                        </th>
                        <td>
                            {{ $talkSubcategories->german }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.english') }}
                        </th>
                        <td>
                            {{ $talkSubcategories->english }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.croatian') }}
                        </th>
                        <td>
                            {{ $talkSubcategories->croatian }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.talk-subcategories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
