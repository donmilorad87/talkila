@extends('layout.mainlayout')
@section('content')

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.talk.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.talks.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.talk.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $talk->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.talk.fields.teacher_user') }}
                                    </th>
                                    <td>
                                        {{ $talk->teacher_user->email ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.talk.fields.languages') }}
                                    </th>
                                    <td>
                                        {{ $talk->language->english ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.talk.fields.anonym_call') }}
                                    </th>
                                    <td>
                                        @if($talk->anonym_call === 1)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.talk.fields.talk_type') }}
                                    </th>
                                    <td>
                                        @if($talk->call_type === 1)
                                            {{ trans('global.video') }}
                                        @else
                                            {{ trans('global.audio') }}
                                        @endif
                                    </td>
                                </tr>
{{--                                <tr>--}}
{{--                                    <th>--}}
{{--                                        {{ trans('cruds.talk.fields.talk_type') }}--}}
{{--                                    </th>--}}
{{--                                    <td>--}}
{{--                                        @if($talk->talk_type === 1)--}}
{{--                                            {{ trans('global.private') }}--}}
{{--                                        @else--}}
{{--                                            {{ trans('global.group') }}--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
                                <tr>
                                    <th>
                                        {{ trans('cruds.talk.fields.interactive_mode') }}
                                    </th>
                                    <td>
                                        @switch($talk->interactive_mode)
                                            @case(\App\Entity\ModeTypes::WATCH)
                                                Watch
                                                @break
                                            @case(\App\Entity\ModeTypes::INTERACTIVE_ALL)
                                                Interactive All
                                                @break
                                            @case(\App\Entity\ModeTypes::INTERACTIVE_SINGLE)
                                                Interactive Single
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.talk.fields.headline') }}
                                    </th>
                                    <td>
                                        {{ $talk->headline }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.talk.fields.description') }}
                                    </th>
                                    <td>
                                        {!! $talk->description !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.talk.fields.duration') }}
                                    </th>
                                    <td>
                                        {{ $talk->duration }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.talk.fields.price') }}
                                    </th>
                                    <td>
                                        {{ $talk->price }}
                                    </td>
                                </tr>
{{--                                <tr>--}}
{{--                                    <th>--}}
{{--                                        {{ trans('cruds.talk.fields.max_participiants') }}--}}
{{--                                    </th>--}}
{{--                                    <td>--}}
{{--                                        {{ $talk->max_participiants }}--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th>--}}
{{--                                        {{ trans('cruds.talk.fields.finance_currencies') }}--}}
{{--                                    </th>--}}
{{--                                    <td>--}}
{{--                                        {{ $talk->finance_currencies->symbol ?? '' }}--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.talks.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
