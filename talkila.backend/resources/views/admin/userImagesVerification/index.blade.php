@extends('layout.mainlayout')
@section('content')
    <h4 class="card-title">{{ trans('cruds.verifications.fields.verification_approval') }} - {{ $total }} {{ trans('cruds.verifications.fields.waiting') }}</h4>
    @if($user)
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-30">
                    <div class="card-body">
                        <div class="row height-365">
                            <div class="col-sm-8">
                                {{--                            @if (file_exists(public_path('assets/images/user/'.$user->user_id.'/'.basename($user->image))))--}}
                                <img style="max-height: 310px;" src="{{ asset($user->image) }}" />
                                {{--                            @endif--}}
                            </div>
                            <div class="col-sm-4">
                                <div class="table-responsive">
                                    <table class="table m-0 text-center table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ trans('cruds.verifications.fields.name') }}
                                                </td>
                                                <td>
                                                    {{ $user->user->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ trans('cruds.user.fields.username') }}
                                                </td>
                                                <td>
                                                    {{ $user->user->username }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ trans('cruds.verifications.fields.acount_created') }}
                                                </td>
                                                <td>
                                                    {{ convertToUserTimezone($user->user->created_at)->toDateTimeString() }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ trans('cruds.verifications.fields.verification_upload') }}
                                                </td>
                                                <td>
                                                    {{ convertToUserTimezone($user->created_at)->toDateTimeString() }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <form action="{{ route('admin.user-image-verification.disapprove', ['id' => $user->id]) }}" method="POST" style="display: block;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-danger btn-block btn-lg mt-3" value="{{ trans('global.disapprove') }}">
                </form>
            </div>
            <div class="col-sm-4">
                <form action="{{ route('admin.user-image-verification.skip', ['id' => $user->id]) }}" method="POST" style="display: block;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-warning btn-block btn-lg mt-3" value="{{ trans('global.skip') }}">
                </form>
            </div>
            <div class="col-sm-4">
                <form action="{{ route('admin.user-image-verification.approve', ['id' => $user->id]) }}" method="POST" style="display: block;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-success btn-block btn-lg mt-3" value="{{ trans('global.approve') }}">
                </form>
            </div>
        </div>
    @endif
@endsection
