@extends('layout.mainlayout')
@section('content')
    <!-- Stats Card -->
    <h5 class="card-title">{{ trans('cruds.feedback.title') }}</h5>

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title"> Booking UNDER REVIEW {{ $requestedBooking->id }}</h5>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <table class="table m-0 text-center table-bordered">
                                <thead>
                                <tr>
                                    <th>{{ trans('global.day') }}</th>
                                    <th>{{ trans('cruds.availability.fields.first_timeslot') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>Talk Name</td>
                                            <td>{{ $talk->headline }}</td>
                                        </tr>
                                        <tr>
                                            <td>Price</td>
                                            <td>{{ $requestedBooking->price }}</td>
                                        </tr>
                                        <tr>
                                            <td>Duration</td>
                                            <td>{{ $requestedBooking->duration }} min</td>
                                        </tr>
                                        <tr>
                                            <!-- Need to calculate -->
                                            <td>Real duration</td>
                                            <td>{{ $requestedBooking->duration }}</td>
                                        </tr>
                                        <tr>
                                            <td>Who quit the talk</td>
                                            <td>{{ $requestedBooking->whoQuitTalk() }}</td>
                                        </tr>
                                        <tr>
                                            <td>Client entered room</td>
                                            <td>{{ $participantTeacher->room_joined ?? null }}</td>
                                        </tr>
                                        <tr>
                                            <td>Supplier entered room</td>
                                            <td>{{ $participantTeacher->room_joined ?? null}}</td>
                                        </tr>
                                        <tr>
                                            <td>Client left room</td>
                                            <td>{{ $participantTeacher->room_end ?? null}}</td>
                                        </tr>
                                        <tr>
                                            <td>Supplier left room</td>
                                            <td>{{ $participantTeacher->room_end ?? null}}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <h3>Comment from Client</h3>
                            <p> {{ $requestedFeedback->description }} </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <form action="{{ route('admin.feedback.updateReviewStatus', $requestedFeedback->id) }}" method="POST" style="display: block;">
                                @csrf
                                <input type="hidden" name="status" value="1">
                                <input type="submit" class="btn btn-success btn-lg btn-block rounded-0 mt-2 mr-2" value="No refund">
                            </form>
                        </div>
                        <div class="col-sm-4">
                            <form action="{{ route('admin.feedback.updateReviewStatus', $requestedFeedback->id) }}" method="POST" style="display: block;">
                                @csrf
                                <input type="hidden" name="status" value="2">
                                <input type="submit" class="btn btn-warning btn-lg btn-block rounded-0 mt-2 mr-2" value="Soft Refund">
                            </form>
                        </div>
                        <div class="col-sm-4">
                            <form action="{{ route('admin.feedback.updateReviewStatus', $requestedFeedback->id) }}" method="POST" style="display: block;">
                                @csrf
                                <input type="hidden" name="status" value="3">
                                <input type="submit" class="btn btn-danger btn-lg btn-block rounded-0 mt-2 mr-2" value="Hard Refund">
                            </form>
                        </div>
                    </div>

                    <div class="form-group mt-3 row">
                        <div class="col-sm-6">
                            <h5 class="card-title"> Client history</h5>

                            <table class="table m-0 text-center table-bordered">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>{{ $talkParticipant->name }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $talkParticipant->email }}</td>
                                </tr>
                                <tr>
                                    <td>Registration</td>
                                    <td>{{ date('d.m.Y H:i', strtotime($talkParticipant->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <!-- Need to recalculate -->
                                    <td>Spend money</td>
                                    <td>{{ $talkParticipant->spentMoney() }}</td>
                                </tr>
                                <tr>
                                    <td>Current Coins</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>Booked Talks</td>
                                    <td>{{ $talkParticipant->participiant_bookings_count }}</td>
                                </tr>
                                <tr>
                                    <td>Canceled Talks</td>
                                    <td>{{ $talkParticipant->canceledTalks('count') }} ({{ $talkParticipant->canceledTalks('percentage') }}%)</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6 ">
                            <h5 class="card-title"> Supplier history</h5>

                            <table class="table m-0 text-center table-bordered">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>{{ $talkTeacher->name }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $talkTeacher->email }}</td>
                                </tr>
                                <tr>
                                    <td>Registration</td>
                                    <td>{{ date('d.m.Y H:i', strtotime($talkTeacher->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <!-- Need to recalculate -->
                                    <td>Spend money</td>
                                    <td>{{ $talkTeacher->spentMoney() }}</td>
                                </tr>
                                <tr>
                                    <td>Current Coins</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>Booked Talks</td>
                                    <td>{{ $talkTeacher->participiant_bookings_count }}</td>
                                </tr>
                                <tr>
                                    <td>Canceled Talks</td>
                                    <td>{{ $talkTeacher->canceledTalks('count') }} ({{ $talkTeacher->canceledTalks('percentage') }}%)</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <h5 class="card-title"> Client last reviews (10)</h5>

                            <table class="table m-0 text-center table-bordered">
                                <thead>
                                    <tr>
                                        <th>Talk-Name</th>
                                        <th>Supplier</th>
                                        <th>Review</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($clientLastFeedback as $clientLas)
                                    <tr>
                                        <td><a href="{{ route('admin.talks.show', [$clientLas['talk_id']]) }}"> {{ $clientLas['talk_name'] }} </a></td>
                                        <td><a href="{{ route('admin.users.show', [$clientLas['teacher_id']]) }}">{{ $clientLas['talk_teacher'] }} </a></td>
                                        <td>{{ $clientLas['talk_reviews'] }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <h5 class="card-title"> Supplier last reviews (10)</h5>

                            <table class="table m-0 text-center table-bordered">
                                <thead>
                                    <tr>
                                        <th>Talk-Name</th>
                                        <th>Supplier</th>
                                        <th>Review</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($teacherLastFeedback as $teacherLast)
                                    <tr>
                                        <td><a href="{{ route('admin.talks.show', [$teacherLast['talk_id']]) }}"> {{ $teacherLast['talk_name'] }} </a></td>
                                        <td><a href="{{ route('admin.users.show', [$teacherLast['teacher_id']]) }}">{{ $teacherLast['talk_teacher'] }} </a></td>
                                        <td>{{ $teacherLast['talk_reviews'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
