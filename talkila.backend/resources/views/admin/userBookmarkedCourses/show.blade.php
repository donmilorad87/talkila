@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userBookmarkedTalks.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-bookmarked-talks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userBookmarkedTalks.fields.id') }}
                        </th>
                        <td>
                            {{ $userBookmarkedTalks->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userBookmarkedTalks.fields.name') }}
                        </th>
                        <td>
                            {{ $userBookmarkedTalks->user_id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userBookmarkedTalks.fields.short_code') }}
                        </th>
                        <td>
                            {{ $userBookmarkedTalks->talks_id }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-bookmarked-talks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
