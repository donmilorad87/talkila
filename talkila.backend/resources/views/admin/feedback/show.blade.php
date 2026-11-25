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
                        <p class="mb-0 fs-25">{{ $booking }} Booked Talks</p><br/>
                        <p class="mb-0 fs-25">0 Revenue</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-4">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0 fs-25">10 Offered Talks</p><br/>
                        <p class="mb-0 fs-25">0 Revenue</p>
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
            <form action="{{ route('admin.users-blocked.store') }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="blocked_user_id" value="{{ $user->id }}">
                <input type="submit" class="btn btn-warning btn-lg btn-block" value="{{ trans('global.block') }} {{ trans('cruds.user.title_singular') }}">
            </form>
        </div>
        <div class="col-sm-4">
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                                <a href="{{ route('admin.bookings.show', $user->id) }}">Bookings ({{ $booking }})</a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.feedback.show', $user->id) }}">Reviews ({{ $reviews }})</a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.talks.show', $user->id) }}">Talks ({{ $talk }})</a>
                            </td>
                            <td class="text-center">
                                <a href="#">Payouts ()</a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.profile-payout-methods.show', $user->id) }}">CV ({{ $profilCv }})</a>
                            </td>
                            <td class="text-center">
                                <a href="#">Billing address ()</a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.show', $user->id) }}">User</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.gender.title') }}</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="">
                                @if($user->gender === 0)
                                    <option>{{ trans('cruds.user.fields.gender.undefined') }}</option>
                                @elseif($user->gender === 1)
                                    <option>{{ trans('cruds.user.fields.gender.male') }}</option>
                                @else
                                    <option>{{ trans('cruds.user.fields.gender.female') }}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.state.title') }}</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="">
                                @if($user->gender === 1)
                                    <option>{{ trans('cruds.user.fields.state.approved') }}</option>
                                @elseif($user->gender === 2)
                                    <option>{{ trans('cruds.user.fields.state.deactivated') }}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.verified') }}</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="">
                                @if($user->gender === 0)
                                    <option>{{ trans('cruds.user.fields.not_verified') }}</option>
                                @elseif($user->gender === 1)
                                    <option>{{ trans('cruds.user.fields.verified') }}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.visibility.title') }}</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="">
                                @if($user->gender === 0)
                                    <option>{{ trans('cruds.user.fields.visibility.visibile') }}</option>
                                @elseif($user->gender === 1)
                                    <option>{{ trans('cruds.user.fields.visibility.open') }}</option>
                                @else
                                    <option>{{ trans('cruds.user.fields.visibility.private') }}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.website') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="website" value="{{ $user->url }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.location') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="location" value="{{ $user->location }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.about_me') }}</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="description">{{ $user->description }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ trans('cruds.user.fields.youtube_video') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="youtube_video" value="{{ $user->youtube_video }}">
                        </div>
                    </div>

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


    <h4>{{ trans('cruds.user.fields.registration_as_teacher') }} ( 0/ 4)</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('cruds.user.fields.state.title') }}</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-RegistrationTeacher">
                            <thead>
                            <tr>
                                <th class="text-center">
                                    {{ trans('cruds.user.fields.step') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.user.fields.name') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.user.fields.created') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.user.fields.state.title') }}
                                </th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



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
                                    {{ trans('cruds.user.fields.type') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.user.fields.type_2') }}
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
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <select class="form-control" name="type" id="type">
                                        <option value="0">- -</option>
                                        <option value="1">Video</option>
                                        <option value="2">Phone</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="type" id="type">
                                        <option value="0">- -</option>
                                        <option value="1">Private</option>
                                        <option value="2">Group</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>

                                </td>
                                <td>
                                    <select class="form-control" name="type" id="type">
                                        <option value="0">- -</option>
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
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <select class="form-control" name="anonym_call" id="anonym_call">
                                        <option value="0">- -</option>
                                        <option value="1">no</option>
                                        <option value="2">yes</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="type" id="type">
                                        <option value="0">- -</option>
                                        <option value="1">Video</option>
                                        <option value="2">Voice</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="type2" id="type2">
                                        <option value="0">- -</option>
                                        <option value="1">Private</option>
                                        <option value="2">Group</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>

                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>

                                </td>
                                <td>
                                    <select class="form-control" name="state" id="state">
                                        <option value="0">- -</option>
                                        <option value="1">open</option>
                                        <option value="2">deleted</option>
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
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>

                                </td>
                                <td>
                                    <select class="form-control" name="state" id="state">
                                        <option value="0">- -</option>
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

    <h4 class="card-title">{{ trans('global.payouts') }}</h4>
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
                                    {{ trans('cruds.staticCommission.commission') }}
                                </th>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <select class="form-control" name="payout_method" id="payout_method">
                                        <option value="0">- -</option>
                                        <option value="1">Adyen</option>
                                        <option value="2">Paypal</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
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

    <h4 class="card-title">{{ trans('cruds.profilCv.curriculum_vitae') }}</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <a type="button" href="{{ route('admin.profile-cvs.create') }}" class="btn btn-primary float-right">{{ trans('global.new') }}</a>
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-ProfilCv">
                            <thead>
                            <tr>
                                <th class="text-center">
                                    {{ trans('cruds.profilCv.fields.id') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.profilCv.fields.type') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('global.timeFrom') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('global.timeTo') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.user.fields.name') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.profilCv.fields.profession') }}
                                </th>
                                <th>

                                </th>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td>
                                    <select class="form-control" name="payout_method" id="payout_method">
                                        <option value="0">- -</option>
                                        <option value="1">Work</option>
                                        <option value="2">Education</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
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
                                    {{ trans('cruds.user.fields.username') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.userBlocked.fields.blocked_user_id') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.userBlocked.fields.blocked_user') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.userBlocked.fields.created_at') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.userBlocked.fields.updated_at') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.user.fields.state.title') }}
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <select class="form-control" name="state" id="state">
                                        <option value="0">- -</option>
                                        <option value="1">valid</option>
                                        <option value="2">deleted</option>
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
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <select class="form-control" name="state" id="state">
                                        <option value="0">- -</option>
                                        <option value="1">valid</option>
                                        <option value="2">deleted</option>
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
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>

                                </td>
                                <td>
                                    <select class="form-control" name="type" id="type">
                                        <option value="0">- -</option>
                                        <option value="1">SPAM</option>
                                        <option value="2">Insult</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="state" id="state">
                                        <option value="0">- -</option>
                                        <option value="1">open</option>
                                        <option value="2">done</option>
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
                                <th class="text-center">

                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>

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

    <h4 class="card-title">{{ trans('cruds.userDontShowAgain.title') }} ({{ $userDontShowAgain }})</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-DontShowAgains">
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
                                <th class="text-center">

                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>

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

{{--    <h4 class="card-title">{{ trans('cruds.emailHistory.title') }}</h4>--}}
{{--    <div class="row">--}}
{{--        <div class="col-xl-12">--}}
{{--            <div class="card mb-30">--}}
{{--                <div class="card-body">--}}
{{--                    <div class="table-responsive">--}}
{{--                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-emailHistory">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th class="text-center">--}}
{{--                                    {{ trans('cruds.emailHistory.fields.type_id') }}--}}
{{--                                </th>--}}
{{--                                <th class="text-center">--}}
{{--                                    {{ trans('cruds.emailHistory.fields.type') }}--}}
{{--                                </th>--}}
{{--                                <th class="text-center">--}}
{{--                                    {{ trans('cruds.user.fields.state.title') }}--}}
{{--                                </th>--}}
{{--                                <th class="text-center">--}}
{{--                                    {{ trans('cruds.verifications.fields.status') }}--}}
{{--                                </th>--}}
{{--                                <th class="text-center">--}}
{{--                                    {{ trans('cruds.emailHistory.fields.created_at') }}--}}
{{--                                </th>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>--}}

{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <select class="form-control" name="type" id="type">--}}
{{--                                        <option value="0">- -</option>--}}
{{--                                        <option value="1">registration</option>--}}
{{--                                        <option value="2">password forgot</option>--}}
{{--                                        <option value="3">payout</option>--}}
{{--                                        <option value="4">sugesstion</option>--}}
{{--                                    </select>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <select class="form-control" name="state" id="state">--}}
{{--                                        <option value="0">- -</option>--}}
{{--                                        <option value="1">send</option>--}}
{{--                                        <option value="2">pending</option>--}}
{{--                                    </select>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <select class="form-control" name="status" id="status">--}}
{{--                                        <option value="0">- -</option>--}}
{{--                                        <option value="200">200</option>--}}
{{--                                        <option value="400">400</option>--}}
{{--                                    </select>--}}
{{--                                </td>--}}
{{--                                <td>--}}

{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}

{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <h4 class="card-title">{{ trans('cruds.search.title') }} ({{ $userSearch }})</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-Searches">
                            <thead>
                            <tr>
                                <th class="text-center">
                                    {{ trans('cruds.search.fields.term') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.search.fields.type') }}
                                </th>
                                <th class="text-center">
                                    {{ trans('cruds.search.fields.created_at') }}
                                </th>
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

    <h4 class="card-title">{{ trans('cruds.talk.fields.favourites_talk') }} ()</h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover">
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
                                <th class="text-center">

                                </th>
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

@endsection
@section('scripts')
    @parent
    <script>
        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.user-bookings.userBookings', $user->id) }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'created_at', name: 'created_at' },
                    {
                        data: 'teacher_user',
                        name: 'teacher_user.name',
                        render: function(data) {
                            if(data.length !== 0){
                                return data.name;
                            }else{
                                return '';
                            }
                        },
                    },
                    {
                        data: 'talk',
                        name: 'talk.headline',
                        render: function(data) {
                            if(data.length !== 0){
                                return data.headline;
                            }else{
                                return '';
                            }
                        },
                    },
                    {
                        data: 'talk',
                        name: 'talk.call_type',
                        render: function(data) {
                            if(data.length !== 0){
                                switch(data.call_type) {
                                    case 1:
                                        return 'Video'
                                        break;
                                    case 2:
                                        return 'Phone'
                                        break;
                                    default:
                                        return ''
                                }
                            }else{
                                return '';
                            }
                        },
                    },
                    {
                        data: 'talk',
                        name: 'talk.talk_type',
                        render: function(data) {
                            if(data.length !== 0){
                                switch(data.talk_type) {
                                    case 1:
                                        return 'Private'
                                        break;
                                    case 2:
                                        return 'Group'
                                        break;
                                    default:
                                        return ''
                                }
                            }else{
                                return '';
                            }
                        },
                    },
                    {
                        data: 'talk',
                        name: 'talk.price',
                        render: function(data) {
                            if(data !== 0){
                                return data.price;
                            }else{
                                return '';
                            }
                        },
                    },
                    {
                        data: 'calls_feedback',
                        name: 'placeholder',
                        render: function(data) {
                            if(data.length !== 0){
                                return data[0].stars_content+'/'+data[0].stars_voice_quality;
                            }else{
                                return '';
                            }
                        },
                    },
                    {
                        data: 'state',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return '<span class="success-color">done</span>'
                                    break;
                                case 2:
                                    return '<span class="danger-color">canceled</span>'
                                    break;
                                case 3:
                                    return '<span class="warning-color">pending</span>'
                                    break;
                                default:
                                    return ''
                            }
                        },
                    },
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-Booking').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable-Booking thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-Booking thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
        });

        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.user-talks.userTalks', $user->id) }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'talks_categories', name: 'talks_categories' },
                    { data: 'headline', name: 'headline' },
                    {
                        data: 'anonym_call',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return 'yes'
                                    break;
                                case 2:
                                    return 'no'
                                    break;
                                default:
                                    return ''
                            }
                        },
                    },
                    {
                        data: 'call_type',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return 'Video'
                                    break;
                                case 2:
                                    return 'Phone'
                                    break;
                                default:
                                    return ''
                            }


                        },
                    },
                    {
                        data: 'talk_type',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return 'Private'
                                    break;
                                case 2:
                                    return 'Group'
                                    break;
                                default:
                                    return ''
                            }
                        }
                    },
                    { data: 'duration', name: 'duration' },
                    { data: 'price', name: 'price' },
                    { data: 'talk_bookings_count', name: 'talk_bookings_count' },
                    { data: 'placeholder', name: 'placeholder' },
                    {
                        data: 'state',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return '<span class="success-color">open</span>'
                                    break;
                                case 2:
                                    return '<span class="danger-color">deleted</span>'
                                    break;
                                default:
                                    return ''
                            }


                        },
                    },
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-Talk').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable-Talk thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-Talk thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
        });

        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.user-feedback.userFeedback', $user->id) }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'calls.talk.created_at', name: 'calls.talk.created_at' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'reviewer.name', name: 'reviewer.name' },
                    { data: 'calls.talk.headline', name: 'calls.talk.headline' },
                    {
                        data: function(data, type, dataToSet) {
                            return data.stars_content+'/'+data.stars_voice_quality;
                        },
                    },

                    {
                        data: 'state',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return '<span class="success-color">done</span>'
                                    break;
                                case 2:
                                    return '<span class="danger-color">canceled</span>'
                                    break;
                                case 3:
                                    return '<span class="warning-color">pending</span>'
                                    break;
                                default:
                                    return ''
                            }
                        },
                    },
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-Review').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable-Review thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-Review thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
        });

        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.user-payout-methods.userPayoutMethod', $user->id) }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'created_at', name: 'created_at' },
                    {
                        data: 'method',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return 'Adyen'
                                    break;
                                case 2:
                                    return 'Paypal'
                                    break;
                                default:
                                    return ''
                            }
                        }
                    },
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'placeholder', name: 'placeholder' },
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-Payouts').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable-Payouts thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-Payouts thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
        });

        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.user-profile-cvs.userProfilCvs', $user->id) }}",
                columns: [
                    { data: 'id', name: 'id' },
                    {
                        data: 'type',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return 'Work'
                                    break;
                                case 2:
                                    return 'Education'
                                    break;
                                default:
                                    return ''
                            }
                        }
                    },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'end_date', name: 'end_date' },
                    { data: 'company_name', name: 'company_name' },
                    { data: 'profession', name: 'profession' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' }
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-ProfilCv').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable-ProfilCv thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-ProfilCv thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
        });

        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.user-blocked.userBlocked', $user->id) }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user.username', name: 'user.username' },
                    { data: 'blocked_user_id', name: 'blocked_user_id' },
                    { data: 'blocked_user.username', name: 'blocked_user.username' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    {
                        data: 'state',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return '<span class="success-color">valid</spam>'
                                    break;
                                case 2:
                                    return '<span class="danger-color">deleted</spam>'
                                    break;
                                default:
                                    return ''
                            }
                        }
                    }
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-Blocked').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable-Blocked thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-Blocked thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
        });

        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.user-followed.userFolloweds', $user->id) }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user.username', name: 'user.username' },
                    { data: 'follower_user_id', name: 'follower_user_id' },
                    { data: 'follower_user.username', name: 'follower_user.username' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    {
                        data: 'state',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return '<span class="success-color">valid</spam>'
                                    break;
                                case 2:
                                    return '<span class="danger-color">deleted</spam>'
                                    break;
                                default:
                                    return ''
                            }
                        }
                    }
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-Followeds').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable-Followeds thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-Followeds thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
        });

        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.user-reported.userReporteds', $user->id) }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user.username', name: 'user.username' },
                    { data: 'reporter_user_id', name: 'reporter_user_id' },
                    { data: 'reporter_user.username', name: 'reporter_user.username' },
                    { data: 'created_at', name: 'created_at' },
                    {
                        data: 'type',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return 'SPAM'
                                    break;
                                case 2:
                                    return 'Insult'
                                    break;
                                default:
                                    return ''
                            }
                        }
                    },
                    {
                        data: 'state',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return '<span class="danger-color">open</spam>'
                                    break;
                                case 2:
                                    return '<span class="success-color">done</spam>'
                                    break;
                                default:
                                    return ''
                            }
                        }
                    }
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-Reporteds').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable-Reporteds thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-Reporteds thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
        });

        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.user-visited.userVisiteds', $user->id) }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user.username', name: 'user.username' },
                    { data: 'visited_user_id', name: 'visited_user_id' },
                    { data: 'visited_user.username', name: 'visited_user.username' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' }
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-Visited').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable-Visited thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-Visited thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
        });

        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.user-dont-show-against.userDontShowAgains', $user->id) }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user.username', name: 'user.username' },
                    { data: 'dont_show_again_user_id', name: 'dont_show_again_user_id' },
                    { data: 'dont_show_again_user.username', name: 'dont_show_again_user.username' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' }
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-DontShowAgains').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable-DontShowAgains thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-DontShowAgains thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
        });

        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.email-histories.showUserEmails', $user->id) }}",
                columns: [
                    { data: 'id', name: 'id' },
                    {
                        data: 'type',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return '<a href="">registration</a>'
                                    break;
                                case 2:
                                    return '<a href="">password forgot</a>'
                                    break;
                                case 3:
                                    return '<a href="">payout</a>'
                                    break;
                                case 4:
                                    return '<a href="">suggestion</a>'
                                    break;
                                default:
                                    return ''
                            }
                        }
                    },
                    {
                        data: 'user.state',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return '<span class="success-color">send</spam>'
                                    break;
                                case 2:
                                    return '<span class="warning-color">pending</spam>'
                                    break;
                                default:
                                    return ''
                            }
                        }
                    },
                    {
                        data: 'placeholder',
                        render: function(data) {
                            switch(data) {
                                case 200:
                                    return '<span class="success-color">200</spam>'
                                    break;
                                case 400:
                                    return '<span class="danger-color">400</spam>'
                                    break;
                                default:
                                    return ''
                            }
                        }
                    },
                    { data: 'created_at', name: 'created_at' }
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-emailHistory').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable-emailHistory thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-emailHistory thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
        });

        $(function () {

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.user-search.userSearches', $user->id) }}",
                columns: [
                    { data: 'term', name: 'term' },
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'created_at', name: 'created_at' }
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            };
            let table = $('.datatable-Searches').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable-Searches thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-Searches thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
        });

    </script>
@endsection
