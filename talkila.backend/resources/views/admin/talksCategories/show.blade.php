@extends('layout.mainlayout')
@section('content')

<div class="card">
    <div class="card-body">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.talksCategories.title') }}
        </div>
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.talk-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.talksCategories.fields.id') }}
                        </th>
                        <td>
                            {{ $talkCategories->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.talksCategories.fields.croatian') }}
                        </th>
                        <td>
                            {{ $talkCategories->croatian }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.talksCategories.fields.german') }}
                        </th>
                        <td>
                            {{ $talkCategories->german }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.talksCategories.fields.croatian') }}
                        </th>
                        <td>
                            {{ $talkCategories->croatian }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.talk-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
