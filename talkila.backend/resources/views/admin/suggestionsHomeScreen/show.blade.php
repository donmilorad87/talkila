@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.suggestionsHomeScreen.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.suggestions-home-screen.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.suggestionsHomeScreen.fields.id') }}
                        </th>
                        <td>
                            {{ $suggestionsHomeScreen->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.suggestionsHomeScreen.fields.user_id') }}
                        </th>
                        <td>
                            {{ $suggestionsHomeScreen->user_id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.suggestionsHomeScreen.fields.language_id') }}
                        </th>
                        <td>
                            {{ $suggestionsHomeScreen->language_id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.suggestionsHomeScreen.fields.categories_id') }}
                        </th>
                        <td>
                            {{ $suggestionsHomeScreen->categories_id }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.suggestions-home-screen.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
