@extends('layout.mainlayout')
@section('content')
    <!-- Stats Card -->
    <h5 class="card-title">{{ trans('cruds.feedback.feedback_approval') }}</h5>
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.staticMetric.fields.reviews') }}</p>
                        <h3 class="mb-0 fs-25">{{ $reviews }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.user.fields.approved') }}</p>
                        <h3 class="mb-0 fs-25">{{ $approved }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.feedback.fields.pending') }}</p>
                        <h3 class="mb-0 fs-25">{{ $pending }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.feedback.fields.rejected') }}</p>
                        <h3 class="mb-0 fs-25">{{ $rejected }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Stats Card -->
    @if($feedback)
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-30">
                    <div class="card-body">
                        <div class="height-365">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <td>{{ trans('cruds.user.fields.supplier') }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $feedback->calls->teacher_user->id) }}">{{ $feedback->calls->teacher_user->name }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.user.fields.client') }}</td>
                                        <td>
                                            @if($feedback->participiant)
                                            <a href="{{ route('admin.users.show', $feedback->participiant->id) }}">
                                                {{ $feedback->participiant->name }}
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.user.fields.created') }}</td>
                                        <td>{{ $feedback->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.talk.title_singular') }}</td>
                                        <td>
                                            <a href="{{ route('admin.talks.show', $feedback->calls->talk->id) }}">
                                                {{ $feedback->calls->talk->headline }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.feedback.fields.rating') }}</td>
                                        <td>
                                            <div class="Stars" style="--rating: {{ $feedback->stars_content }};"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.feedback.fields.voice') }}</td>
                                        <td>
                                            <div class="Stars" style="--rating: {{ $feedback->stars_voice_quality / 2 }};"></div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-30">
                    <div class="card-body">
                        <div class="height-365" style="padding: 15px">
                            <p>{!! $feedback->description !!}</p>
                            <div class="row" style="position:absolute;
bottom:15px; width: 95%">
                                <div class="col-sm-4">
                                    <form action="{{ route('admin.feedback.updateStatus', $feedback->id) }}" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="status" value="1">
                                        <input type="submit" class="btn btn-success btn-lg btn-block rounded-0 mt-2 mr-2" value="{{ trans('global.approve') }}">
                                    </form>
                                </div>
                                <div class="col-sm-4">
                                    <form action="{{ route('admin.feedback.updateStatus', $feedback->id) }}" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="status" value="3">
                                        <input type="submit" class="btn btn-warning btn-lg btn-block rounded-0 mt-2 mr-2" value="{{ trans('global.skip') }}">
                                    </form>
                                </div>
                                <div class="col-sm-4">
                                    <form action="{{ route('admin.feedback.updateStatus', $feedback->id) }}" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="status" value="2">
                                        <input type="submit" class="btn btn-danger btn-lg btn-block rounded-0 mt-2 mr-2" value="{{ trans('global.decline') }}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

