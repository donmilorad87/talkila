@extends('layout.mainlayout')
@section('content')
    <!-- Main Content Header -->
    <div class="main-content-header">
        <h1>{{ $user->name }} ({{ $user->login_type }}) {{ $user->id }}
            @if($user->verified)
                <span class="success-color">Verified</span>
            @else
                <span class="danger-color">Not verified</span>
            @endif
        </h1>
    </div>
    <!-- End Main Content Header -->

    <!-- Stats Card -->
    <div class="row">
        <div class="col-lg-4 col-sm-4">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0 fs-25">{{ $booking }} Booked Talks</p>
                        <br />
                        <p class="mb-0 fs-25">{{ number_format((float)$bookingRevenue, 2, '.', '') }} Revenue</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-4">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0 fs-25">{{ $talk }} Offered Talks</p>
                        <br />
                        <p class="mb-0 fs-25">{{ number_format((float)$talkRevenue, 2, '.', '') }} Revenue</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-4">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="success-color mb-0 fs-25">Acount active</span>
                        <p class="mb-0 fs-16">Created ad: {{ $user->created_at }}</p>
                        <p class="mb-0 fs-16">Last Login: {{ $user->last_login }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Stats Card -->

    <div class="row">
        <div class="col-sm-4">

        </div>
        <div class="col-sm-4">
            <form action="{{ route('admin.users-blocked.store') }}" method="POST" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="blocked_user_id" value="{{ $user->id }}">
                <input type="submit" class="btn btn-warning btn-lg btn-block" value="{{ trans('global.block') }} {{ trans('cruds.user.title_singular') }}">
            </form>
        </div>
        <div class="col-sm-4">
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="btn btn-danger btn-lg btn-block" value="{{ trans('global.delete') }} {{ trans('cruds.user.title_singular') }}">
            </form>
        </div>
    </div>
    </br>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="table-responsive">
                    <table class="table m-0 text-center table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <a href="#bookings-table">Bookings ({{ $booking }})</a>
                                </td>
                                <td class="text-center">
                                    <a href="#reviews-table">Reviews ({{ $reviews }})</a>
                                </td>
                                <td class="text-center">
                                    <a href="#talks-table">Talks ({{ $talk }})</a>
                                </td>
                                <td class="text-center">
                                    <a href="#payouts-table">Payouts ({{ $payouts  }})</a>
                                </td>
                                {{--                                <td class="text-center">--}}
                                {{--                                    <a href="#cv-table">CV ({{ $profilCv }})</a>--}}
                                {{--                                </td>--}}
                                <td class="text-center">
                                    <a href="#favourite-talk-table">Bookmarks ({{ $userBookTalks }})</a>
                                </td>
                                <td class="text-center">
                                    <a href="#billing-table">Billing address ({{ $billingAddress }})</a>
                                </td>
                                <td class="text-center">
                                    <a href="#user-table">User</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <a name="user-table"></a>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.username') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" value="{{ $user->username }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" value="{{ $user->name }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.email') }}</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}">
                        </div>
                    </div>

{{--                    <div class="form-group row">--}}
{{--                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.gender.title') }}</label>--}}
{{--                        <div class="col-sm-10">--}}
{{--                            <input type="text" class="form-control" id="gender"--}}
{{--                                   @if($user->gender === 0)--}}
{{--                                       value="{{ trans('cruds.user.fields.gender.undefined') }}"--}}
{{--                                   @elseif($user->gender === 1)--}}
{{--                                       value="{{ trans('cruds.user.fields.gender.male') }}"--}}
{{--                                   @elseif($user->gender === 2)--}}
{{--                                       value="{{ trans('cruds.user.fields.gender.female') }}"--}}
{{--                                    @endif>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.state.title') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="state"
                                   @if($user->state === 1)
                                       value="{{ trans('cruds.user.fields.state.approved') }}"
                                   @elseif($user->state === 2)
                                       value="{{ trans('cruds.user.fields.state.deactivated') }}"
                                    @endif>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.verified') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="verified"
                                   @if($user->verified === 0)
                                       value="{{ trans('cruds.user.fields.not_verified') }}"
                                   @elseif($user->verified === 1)
                                       value="{{ trans('cruds.user.fields.verified') }}"
                                    @endif>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.visibility.title') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="visibility"
                                   @if($user->visibility === 0)
                                       value="{{ trans('cruds.user.fields.visibility.visibile') }}"
                                   @elseif($user->visibility === 1)
                                       value="{{ trans('cruds.user.fields.visibility.open') }}"
                                   @elseif($user->visibility === 2)
                                       value="{{ trans('cruds.user.fields.visibility.private') }}"
                                    @endif>
                        </div>
                    </div>

{{--                    <div class="form-group row">--}}
{{--                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.website') }}</label>--}}
{{--                        <div class="col-sm-10">--}}
{{--                            <input type="text" class="form-control" id="website" value="{{ $user->url }}">--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.about_me') }}</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="description">{{ $user->description }}</textarea>
                        </div>
                    </div>

{{--                    <div class="form-group row">--}}
{{--                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.youtube_video') }}</label>--}}
{{--                        <div class="col-sm-10">--}}
{{--                            <input type="text" class="form-control" id="youtube_video" value="{{ $user->youtube_video }}">--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <iframe src="{{ $user->youtube_video }}"
                                    width="100%" height="315" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.availability.title') }}</label>
                        <div class="col-sm-10">
                            <table class="table m-0 text-center table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ trans('global.day') }}</th>
                                        <th>{{ trans('cruds.availability.fields.first_timeslot') }}</th>
                                        <th>{{ trans('cruds.availability.fields.second_timeslot') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->userAvailabilities as $userA)
                                        @if($userA->weekday == 1)
                                            <tr>
                                                <td>{{ trans('global.monday') }}</td>
                                                <td>{{ $userA->start_time }}</td>
                                                <td>{{ $userA->end_time }}</td>
                                            </tr>
                                        @endif
                                        @if($userA->weekday == 2)
                                            <tr>
                                                <td>{{ trans('global.tuesday') }}</td>
                                                <td>{{ $userA->start_time }}</td>
                                                <td>{{ $userA->end_time }}</td>
                                            </tr>
                                        @endif
                                        @if($userA->weekday == 3)
                                            <tr>
                                                <td>{{ trans('global.wednesday') }}</td>
                                                <td>{{ $userA->start_time }}</td>
                                                <td>{{ $userA->end_time }}</td>
                                            </tr>
                                        @endif
                                        @if($userA->weekday == 4)
                                            <tr>
                                                <td>{{ trans('global.thursday') }}</td>
                                                <td>{{ $userA->start_time }}</td>
                                                <td>{{ $userA->end_time }}</td>
                                            </tr>
                                        @endif
                                        @if($userA->weekday == 5)
                                            <tr>
                                                <td>{{ trans('global.friday') }}</td>
                                                <td>{{ $userA->start_time }}</td>
                                                <td>{{ $userA->end_time }}</td>
                                            </tr>
                                        @endif
                                        @if($userA->weekday == 6)
                                            <tr>
                                                <td>{{ trans('global.saturday') }}</td>
                                                <td>{{ $userA->start_time }}</td>
                                                <td>{{ $userA->end_time }}</td>
                                            </tr>
                                        @endif
                                        @if($userA->weekday == 7)
                                            <tr>
                                                <td>{{ trans('global.sunday') }}</td>
                                                <td>{{ $userA->start_time }}</td>
                                                <td>{{ $userA->end_time }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h4>{{ trans('cruds.user.fields.registration_as_teacher') }}</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('cruds.user.fields.state.title') }}</h5>
                    </div>
                    <div class="table-responsive">
                        @if ($clubStatus)
                            <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-JTC">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            {{ trans('cruds.user.fields.id') }}
                                        </th>
                                        <th class="text-center">
                                            {{ trans('cruds.user.fields.step') }}
                                        </th>
                                        <th class="text-center">
                                            {{ trans('cruds.user.fields.created') }}
                                        </th>
                                        <th class="text-center">
                                            {{ trans('cruds.user.fields.state.title') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            {{ $clubStatus->users_id }}
                                        </td>
                                        <td class="text-center">
                                            {{ $clubStatus->completed_step }}
                                        </td>
                                        <td class="text-center">
                                            {{ $clubStatus->created_at }}
                                        </td>
                                        <td class="text-center">
                                            {{ $clubStatus->state === 0 ? 'Pending' : 'Completed' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <h3 style="text-align: center">User has not started Join The Club process.</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a name="bookings-table"></a>
    <h4 class="card-title">{{ trans('cruds.booking.title') }} ({{ $booking }})</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-Booking">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.booking.fields.id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('global.date') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.booking.fields.provider') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.booking.fields.talk') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.fields.call_type') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.fields.talk_type') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.booking.fields.price') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.feedback.title') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.state.title') }}
                                    </th>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="form-control" name="type" id="type">
                                            <option value>- -</option>
                                            <option value="1">Video</option>
                                            <option value="2">Phone</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="type" id="type">
                                            <option value>- -</option>
                                            <option value="1">Private</option>
                                            <option value="2">Group</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <select class="form-control" name="type" id="type">
                                            <option value>- -</option>
                                            <option value="1">done</option>
                                            <option value="2">cancelled</option>
                                            <option value="3">pending</option>
                                        </select>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a name="talks-table"></a>
    <h4 class="card-title">{{ trans('cruds.talk.title') }} ({{ $talk }})</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-Talk">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.booking.fields.id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('global.created_at') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('global.category') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.title_singular') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.fields.anonym_call') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.fields.call_type') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.fields.talk_type') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.fields.duration') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.fields.price') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talksBooking.fields.booking') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.staticMetric.fields.revenue') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.state.title') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="form-control" name="category" id="category">
                                            <option value>{{ trans('global.all') }}</option>
                                            @if($categories)
                                                @foreach($categories as $c)
                                                    <option value="{{ $c->english }}">{{ $c->english }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="form-control" name="anonym_call" id="anonym_call">
                                            <option value>- -</option>
                                            <option value="0">no</option>
                                            <option value="1">yes</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="type" id="type">
                                            <option value>- -</option>
                                            <option value="1">Video</option>
                                            <option value="2">Voice</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="type2" id="type2">
                                            <option value>- -</option>
                                            <option value="1">Private</option>
                                            <option value="2">Group</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="type2" id="type2">
                                            <option value>- -</option>
                                            <option value="15">15</option>
                                            <option value="30">30</option>
                                            <option value="45">45</option>
                                            <option value="60">60</option>
                                            <option value="75">75</option>
                                            <option value="90">90</option>
                                            <option value="105">105</option>
                                            <option value="120">120</option>
                                            <option value="135">135</option>
                                            <option value="150">150</option>
                                            <option value="165">165</option>
                                            <option value="180">180</option>
                                        </select>
                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <select class="form-control" name="state" id="state">
                                            <option value>- -</option>
                                            <option value="1">open</option>
                                            <option value="2">deleted</option>
                                            <option value="3">pause</option>
                                        </select>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a name="reviews-table"></a>
    <h4 class="card-title">{{ trans('cruds.feedback.fields.reviews') }} ({{ $reviews }})</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-Review">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.booking.fields.id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.fields.date_talk') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.feedback.fields.date_feedback') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.booking.fields.provider') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.title_singular') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.feedback.title_singular') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.state.title') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <select class="form-control" name="state" id="state">
                                            <option value>- -</option>
                                            <option value="1">done</option>
                                            <option value="2">cancelled</option>
                                            <option value="3">pending</option>
                                        </select>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a name="payouts-table"></a>
    <h4 class="card-title">{{ trans('global.payouts') }} ({{ $payouts }})</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-Payouts">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.booking.fields.id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('global.month') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.profilPayoutMethod.payout_method') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.booking.title') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.staticMetric.fields.revenue') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('global.commision') }}
                                    </th>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="form-control" name="payout_method" id="payout_method">
                                            <option value>- -</option>
                                            <option value="1">Adyen</option>
                                            <option value="2">Paypal</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a name="billing-table"></a>
    <h4 class="card-title">{{ trans('cruds.billingAddress.title') }} ({{ $billingAddress }})</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-billingAddress">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.billingAddress.fields.id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.billingAddress.fields.company_name') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.billingAddress.fields.street') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.billingAddress.fields.zipcode') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.billingAddress.fields.city') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.billingAddress.fields.tax_number') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.billingAddress.fields.pays_vat') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.billingAddress.fields.state') }}
                                    </th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <select class="form-control" name="state" id="state">
                                            <option value>- -</option>
                                            <option value="1">active</option>
                                            <option value="2">cancelled</option>
                                            <option value="3">pending</option>
                                        </select>
                                    </td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="card-title">{{ trans('cruds.userBlocked.title') }} ({{ $blocked }})</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-Blocked">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.userBlocked.fields.blocked_user_id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.username') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.username') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.userBlocked.fields.created_at') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.state.title') }}
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="form-control" name="state" id="state">
                                            <option value>- -</option>
                                            <option value="1">valid</option>
                                            <option value="2">deleted</option>
                                        </select>
                                    </td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="card-title">{{ trans('cruds.userFollowed.title') }} ({{ $followed }})</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-Followeds">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.username') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.userFollowed.fields.follower_user_id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.userFollowed.fields.follower_user') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.userFollowed.fields.created_at') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.userFollowed.fields.updated_at') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.state.title') }}
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <select class="form-control" name="state" id="state">
                                            <option value>- -</option>
                                            <option value="1">valid</option>
                                            <option value="2">deleted</option>
                                        </select>
                                    </td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="card-title">{{ trans('cruds.userReported.title') }} ({{ $reported }})</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-Reporteds">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.username') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.userReported.fields.reporter_user_id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.userReported.fields.reporter_user') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.userBlocked.fields.created_at') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.type') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.state.title') }}
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td></td>
                                    <td>
                                        <select class="form-control" name="type" id="type">
                                            <option value>- -</option>
                                            <option value="1">SPAM</option>
                                            <option value="2">Insult</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="state" id="state">
                                            <option value>- -</option>
                                            <option value="1">open</option>
                                            <option value="2">done</option>
                                        </select>
                                    </td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="card-title">{{ trans('cruds.userVisited.title') }} ({{ $visited }})</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-Visited">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.username') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.userVisited.fields.visited_user_id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.userVisited.fields.visited_user') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.userBlocked.fields.created_at') }}
                                    </th>
                                    <th class="text-center"></th>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="card-title">{{ trans('cruds.emailHistory.title') }} ({{ $emailHistoryCount }})</h4>
    <a name="email-table"></a>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-emailHistory">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.emailHistory.fields.type_id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.emailHistory.fields.subject') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.state.title') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.emailHistory.fields.created_at') }}
                                    </th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="form-control" name="state" id="state">
                                            <option value>- -</option>
                                            <option value="1">send</option>
                                            <option value="2">pending</option>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="card-title">{{ trans('cruds.talk.fields.favourites_talk') }} ({{ $userBookTalks }})</h4>
    <a name="favourite-talk-table"></a>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-userBookTalks">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.user_id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.user.fields.username') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.fields.talk_id') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.title_singular') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('cruds.talk.fields.created_at') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
    <script>
        $(function () {

            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.user-followed.userFolloweds', $user->id) }}",
                columns      : [
                    { data: 'id', name: 'id' },
                    { data: 'user.username', name: 'user.username' },
                    {
                        name: 'follower_user_id',
                        data: function (data, type, row) {
                            if (data.users !== null) {
                                return '<a class="link" href="../users/' + data.follower_user_id + '">' + data.follower_user_id + '</a>';
                            } else {
                                return '';
                            }
                        },
                    },
                    {
                        name: 'follower_user',
                        data: function (data, type, row) {
                            if (data !== null) {
                                return '<a class="link" href="../users/' + data.follower_user.id + '">' + data.follower_user.username + '</a>';
                            } else {
                                return '';
                            }
                        },
                    },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    {
                        data  : 'state',
                        render: function (data) {
                            switch (data) {
                                case 0:
                                    return '<span class="danger-color">deleted</spam>';
                                case 1:
                                    return '<span class="success-color">valid</spam>';
                                case 2:
                                    return '<span class="warning-color">pending</spam>';
                                default:
                                    return '';
                            }
                        },
                    },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-Followeds').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-Followeds thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-Followeds thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });

        $(function () {

            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.user-profile-cvs.userProfilCvs', $user->id) }}",
                columns      : [
                    { data: 'id', name: 'id' },
                    {
                        data  : 'type',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return 'Work';
                                case 2:
                                    return 'Education';
                                default:
                                    return '';
                            }
                        },
                    },
                    {
                        name: 'start_date',
                        data: function (data, type, row) {
                            if (data.users !== null) {
                                return '<a class="link" href="../profile-cvs/' + data.id + '">' + data.start_date + '</a>';
                            } else {
                                return '';
                            }
                        },
                    },
                    {
                        name: 'end_date',
                        data: function (data, type, row) {
                            if (data.users !== null) {
                                return '<a class="link" href="../profile-cvs/' + data.id + '">' + data.end_date + '</a>';
                            } else {
                                return '';
                            }
                        },
                    },
                    {
                        name: 'company_name',
                        data: function (data, type, row) {
                            if (data.users !== null) {
                                return '<a class="link" href="../profile-cvs/' + data.id + '">' + data.company_name + '</a>';
                            } else {
                                return '';
                            }
                        },
                    },
                    {
                        name: 'profession',
                        data: function (data, type, row) {
                            if (data.users !== null) {
                                return '<a class="link" href="../profile-cvs/' + data.id + '">' + data.profession + '</a>';
                            } else {
                                return '';
                            }
                        },
                    },
                    { data: 'actions', name: '{{ trans('global.actions') }}' },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-ProfilCv').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-ProfilCv thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-ProfilCv thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });

        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.user-bookings.userBookings', $user->id) }}",
                columns      : [
                    { data: 'id', name: 'id' },
                    { data: 'created_at', name: 'created_at' },
                    {
                        name: 'teacher_user_with_trashed.name',
                        data: function (data, type, row) {
                            if (data.users !== null) {
                                return '<a class="link" target="_blank" href="../users/' + data.id + '">' + data.teacher_user_with_trashed.name + '</a>';
                            } else {
                                return '';
                            }
                        },
                    },
                    {
                        name: 'talk.headline',
                        data: function (data, type, row) {
                            if (data.users !== null) {
                                return '<a class="link" target="_blank" href="../talks/' + data.talk.id + '">' + data.talk.headline + '</a>';
                            } else {
                                return '';
                            }
                        },
                    },
                    {
                        data  : 'talk',
                        name  : 'talk.call_type',
                        render: function (data) {
                            switch (data.call_type) {
                                case 1:
                                    return 'Video';
                                case 2:
                                    return 'Phone';
                                default:
                                    return '';
                            }
                        },
                    },
                    {
                        data  : 'talk',
                        name  : 'talk.talk_type',
                        render: function (data) {
                            switch (data.talk_type) {
                                case 1:
                                    return 'Private';
                                case 2:
                                    return 'Group';
                                default:
                                    return '';
                            }
                        },
                    },
                    { data: 'talk.price', name: 'talk.price' },
                    {
                        data  : 'talks_feedback',
                        name  : 'placeholder',
                        render: function (data) {
                            if (data) {
                                return data.stars_content + '/' + data.stars_voice_quality;
                            } else {
                                return 'not given';
                            }
                        },
                    },
                    {
                        data  : 'state',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return '<span class="success-color">done</span>';
                                case 2:
                                    return '<span class="danger-color">canceled</span>';
                                case 3:
                                    return '<span class="warning-color">pending</span>';
                                default:
                                    return '';
                            }
                        },
                    },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-Booking').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-Booking thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-Booking thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });

        $(function () {

            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.user-talks.userTalks', $user->id) }}",
                columns      : [
                    { data: 'id', name: 'id' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'talk_categories_english', name: 'talk_categories_english' },
                    { data: 'headline', name: 'headline' },
                    {
                        data  : 'anonym_call',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return 'yes';
                                case 0:
                                    return 'no';
                                default:
                                    return '';
                            }
                        },
                    },
                    {
                        data  : 'call_type',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return 'Video';
                                case 2:
                                    return 'Voice';
                                default:
                                    return '';
                            }


                        },
                    },
                    {
                        data  : 'talk_type',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return 'Private';
                                case 2:
                                    return 'Group';
                                default:
                                    return '';
                            }
                        },
                    },
                    { data: 'duration', name: 'duration' },
                    { data: 'price', name: 'price' },
                    { data: 'talk_bookings_count', name: 'talk_bookings_count' },
                    {
                        data: function (data, type, dataToSet) {
                            return data.price * data.talk_bookings_count;
                        },
                    },
                    {
                        data  : 'state',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return '<span class="success-color">open</span>';
                                case 2:
                                    return '<span class="danger-color">deleted</span>';
                                case 3:
                                    return '<span class="warning-color">pause</span>';
                                default:
                                    return '';
                            }
                        },
                    },
                    { data: 'actions', name: '{{ trans('global.actions') }}' },
                ],
                columnDefs   : [
                    {
                        targets  : 3,
                        className: 'example_matched_left',
                    },
                ],
                orderCellsTop: true,
                order        : [[1, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-Talk').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-Talk thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-Talk thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });

        $(function () {

            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.user-feedback.userFeedback', $user->id) }}",
                columns      : [
                    {
                        data  : 'id',
                        render: function (data, type, row) {
                            return '<a class="link" href="../feedback/' + row.id + '/edit">' + data + '</a>';
                        },
                    },
                    { data: 'calls.talk.created_at', name: 'calls.talk.created_at' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'reviewer.name', name: 'reviewer.name' },
                    { data: 'calls.talk.headline', name: 'calls.talk.headline' },
                    {
                        data: function (data, type, dataToSet) {
                            return data.stars_content + '/' + data.stars_voice_quality;
                        },
                    },

                    {
                        data  : 'state',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return '<span class="success-color">done</span>';
                                case 2:
                                    return '<span class="danger-color">canceled</span>';
                                case 3:
                                    return '<span class="warning-color">pending</span>';
                                default:
                                    return '';
                            }
                        },
                    },
                    { data: 'actions', name: '{{ trans('global.actions') }}' },
                ],
                columnDefs   : [
                    {
                        targets  : 3,
                        className: 'example_matched_left',
                    },
                    {
                        targets  : 4,
                        className: 'example_matched_left',
                    },
                ],
                orderCellsTop: true,
                order        : [[1, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-Review').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-Review thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-Review thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });

        $(function () {

            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.user-booked-talks.userBookmarkedTalks', $user->id) }}",
                columns      : [
                    { data: 'id', name: 'id' },
                    { data: 'user.username', name: 'user.username' },
                    { data: 'talks_id', name: 'talks_id' },
                    { data: 'talk.headline', name: 'talk.headline' },
                    { data: 'created_at', name: 'created_at' },
                ],
                orderCellsTop: true,
                order        : [[1, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-userBookTalks').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-userBookTalks thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-userBookTalks thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });

        $(function () {

            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.user-payout-methods.userPayoutMethod', $user->id) }}",
                columns      : [
                    { data: 'id', name: 'id' },
                    { data: 'created_at', name: 'created_at' },
                    {
                        data  : 'method',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return 'Adyen';
                                case 2:
                                    return 'Paypal';
                                default:
                                    return '';
                            }
                        },
                    },
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'placeholder', name: 'placeholder' },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-Payouts').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-Payouts thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-Payouts thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });

        $(function () {

            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.user-billing-addresses.userBillingAddresses', $user->id) }}",
                columns      : [
                    {
                        data  : 'id',
                        render: function (data, type, row) {
                            return '<a class="link" href="../billing-addresses/' + row.id + '/edit">' + data + '</a>';
                        },
                    },
                    { data: 'company_name', name: 'company_name' },
                    { data: 'street', name: 'street' },
                    { data: 'zipcode', name: 'zipcode' },
                    { data: 'city', name: 'city' },
                    { data: 'tax_number', name: 'tax_number' },
                    {
                        data  : 'pays_vat',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return 'Yes';
                                default:
                                    return 'No';
                            }
                        },
                    },
                    {
                        data  : 'state',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return '<span class="success-color">active</span>';
                                case 0:
                                    return '<span class="danger-color">not active</span>';
                                default:
                                    return '';
                            }
                        },
                    },
                ],
                orderCellsTop: true,
                order        : [[0, 'desc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-billingAddress').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-billingAddress thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-billingAddress thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });

        $(function () {

            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.user-blocked.userBlocked', $user->id) }}",
                columns      : [
                    { data: 'id', name: 'id' },
                    {
                        data  : 'blocked_user_id',
                        render: function (data, type, row) {
                            return '<a class="link" target="_blank" href="../users/' + data + '">' + data + '</a>';
                        },
                    },
                    {
                        data  : 'name',
                        render: function (data, type, row) {
                            return '<a class="link" target="_blank" href="../users/' + row.blocked_user_id + '">' + data + '</a>';
                        },
                    },
                    {
                        data  : 'username',
                        render: function (data, type, row) {
                            return '<a class="link" target="_blank" href="../users/' + row.blocked_user_id + '">' + data + '</a>';
                        },
                    },
                    { data: 'created_at', name: 'created_at' },
                    {
                        data  : 'state',
                        render: function (data) {
                            switch (data) {
                                case 0:
                                    return '<span class="danger-color">deleted</spam>';
                                case 1:
                                    return '<span class="success-color">valid</spam>';
                                default:
                                    return '';
                            }
                        },
                    },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-Blocked').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-Blocked thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-Blocked thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });

        $(function () {

            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.user-reported.userReporteds', $user->id) }}",
                columns      : [
                    { data: 'id', name: 'id' },
                    { data: 'user.username', name: 'user.username' },
                    { data: 'reporter_user_id', name: 'reporter_user_id' },
                    { data: 'reporter_user.username', name: 'reporter_user.username' },
                    { data: 'created_at', name: 'created_at' },
                    {
                        data  : 'type',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return 'SPAM';
                                case 2:
                                    return 'Insult';
                                default:
                                    return '';
                            }
                        },
                    },
                    {
                        data  : 'state',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return '<span class="danger-color">open</spam>';
                                case 2:
                                    return '<span class="success-color">done</spam>';
                                default:
                                    return '';
                            }
                        },
                    },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-Reporteds').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-Reporteds thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-Reporteds thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });

        {{-- $(function () { --}}

        {{--     let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons); --}}
        {{--     let dtOverrideGlobals = { --}}
        {{--         buttons      : dtButtons, --}}
        {{--         processing   : true, --}}
        {{--         serverSide   : true, --}}
        {{--         retrieve     : true, --}}
        {{--         aaSorting    : [], --}}
        {{--         ajax         : "{{ route('admin.user-visited.userVisiteds', $user->id) }}", --}}
        {{--         columns      : [ --}}
        {{--             { data: 'id', name: 'id' }, --}}
        {{--             { data: 'user.username', name: 'user.username' }, --}}
        {{--             { data: 'visited_user_id', name: 'visited_user_id' }, --}}
        {{--             { data: 'visited_user.username', name: 'visited_user.username' }, --}}
        {{--             { data: 'created_at', name: 'created_at' }, --}}
        {{--             { data: 'actions', name: '{{ trans('global.actions') }}' }, --}}
        {{--         ], --}}
        {{--         orderCellsTop: true, --}}
        {{--         order        : [[0, 'asc']], --}}
        {{--         pageLength   : 10, --}}
        {{--     }; --}}
        {{--     let table             = $('.datatable-Visited').DataTable(dtOverrideGlobals); --}}
        {{--     $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) { --}}
        {{--         $($.fn.dataTable.tables(true)).DataTable().columns.adjust(); --}}
        {{--     }); --}}
        {{--     $('.datatable-Visited thead').on('input', '.search', function () { --}}
        {{--         let strict = $(this).attr('strict') || false; --}}
        {{--         let value  = strict && this.value ? '^' + this.value + '$' : this.value; --}}
        {{--         table.column($(this).parent().index()) --}}
        {{--              .search(value, strict) --}}
        {{--              .draw(); --}}
        {{--     }); --}}
        {{--     $('.datatable-Visited thead select').on('change', function () { --}}
        {{--         let strict = $(this).attr('strict') || false; --}}
        {{--         var val    = $.fn.dataTable.util.escapeRegex($(this).val()); --}}

        {{--         table.column($(this).parent().index()) --}}
        {{--              .search(val, strict) --}}
        {{--              .draw(); --}}
        {{--     }); --}}
        {{-- }); --}}

        $(function () {

            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.user-dont-show-against.userDontShowAgainst', $user->id) }}",
                columns      : [
                    { data: 'id', name: 'id' },
                    { data: 'user.username', name: 'user.username' },
                    { data: 'dont_show_again_user_id', name: 'dont_show_again_user_id' },
                    { data: 'dont_show_again_user.username', name: 'dont_show_again_user.username' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-DontShowAgains').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-DontShowAgains thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-DontShowAgains thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });

        $(function () {

            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.email-histories.showUserEmails', $user->id) }}",
                columns      : [
                    { data: 'id', name: 'id' },
                    { data: 'subject', name: 'subject' },
                    {
                        data  : 'state',
                        render: function (data) {
                            switch (data) {
                                case 0:
                                    return '<span class="success-color">send</spam>';
                                case 1:
                                    return '<span class="warning-color">pending</spam>';
                                default:
                                    return '';
                            }
                        },
                    },
                    { data: 'created_at', name: 'created_at' },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-emailHistory').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-emailHistory thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-emailHistory thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });

        $(function () {

            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.user-search.userSearches', $user->id) }}",
                columns      : [
                    { data: 'term', name: 'term' },
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'created_at', name: 'created_at' },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-Searches').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable-Searches thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index())
                     .search(value, strict)
                     .draw();
            });
            $('.datatable-Searches thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index())
                     .search(val, strict)
                     .draw();
            });
        });
    </script>
@endsection
