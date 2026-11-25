@extends('layout.mainlayout')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <br />
                <div class="row">
                    <div class="col-12">
                        <div class="card socket-create">
                            <div class="card-header">
                                <h3 class="card-title">{{ trans('cruds.socketRoomsAdmin.fields.create_test_room') }}</h3>
                                {{--                                <span>|</span>--}}
                                {{--                                <div class="card-title">Server Time--}}
                                {{--                                    <span class="time server-time"></span>--}}
                                {{--                                </div>--}}
                                {{--                                <span>|</span>--}}
                                {{--                                <div class="card-title">Browser Time--}}
                                {{--                                    <span class="time client-time"></span>--}}
                                {{--                                </div>--}}
                            </div>

                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            <!-- Form -->
                            <form method="POST" id="form-test-room" action="{{ route('admin.bookings.storeBooking') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="socket_room_booking" value="1">
                                <input type="hidden" name="admin_panel" value="1">
                                <input type="hidden" id="timezone_offset" name="timezone_offset" value="">
                                <div class="card-body">

                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <label for="talk_id">{{ trans('cruds.socketRoomsAdmin.fields.talk_id') }}</label>--}}
                                    {{--                                        <div class="select-supplier-picker">--}}
                                    {{--                                            <label for="talk_id">Choose a teacher:</label>--}}
                                    {{--                                            <input list="talk_id_select" id="talk_id" name="talk_id" autocomplete="off"/>--}}
                                    {{--                                            <span type="button" class="clear_button" tabindex="-1">✖</span>--}}
                                    {{--                                            <datalist id="talk_id_select">--}}
                                    {{--                                                @include('admin.includes._pick_teacher_select')--}}
                                    {{--                                            </datalist>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.talk_id_helper') }}</small>--}}
                                    {{--                                    </div>--}}

                                    <div class="form-group">
                                        <label for="teacher">Select supplier</label>
                                        <select class="selectpicker form-control" data-live-search="true" data-size="10" id="teacher" name="teacher" required>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{$supplier['id'] }}">{{ $supplier['name'] }} - {{ $supplier['email'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="talksHolder" style="display: none;">
                                        <label for="talk_id">{{ trans('cruds.socketRoomsAdmin.fields.talk_id') }}</label>
                                        <div id="talksSelectHolder">
                                            @include('admin.includes._pick_teacher_select')
                                        </div>
                                        <div class="d-none validation_message"></div>
                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.talk_id_helper') }}</small>
                                    </div>

                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <label class="required" for="room_name">{{ trans('cruds.socketRoomsAdmin.fields.room_name') }}</label>--}}
                                    {{--                                        <input class="form-control {{ $errors->has('room_name') ? 'is-invalid' : '' }}" type="text" name="room_name" id="room_name" value="{{ old('room_name', '') }}" required>--}}
                                    {{--                                        @if($errors->has('room_name'))--}}
                                    {{--                                            <div class="invalid-feedback">--}}
                                    {{--                                                {{ $errors->first('room_name') }}--}}
                                    {{--                                            </div>--}}
                                    {{--                                        @endif--}}
                                    {{--                                        <div class="d-none validation_message"></div>--}}
                                    {{--                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.room_name_helper') }}</small>--}}
                                    {{--                                    </div>--}}
                                    <div class="form-group">
                                        <label for="talk_type">{{ trans('cruds.socketRoomsAdmin.fields.talk_type') }}</label>
                                        <select class="form-control {{ $errors->has('talk_type') ? 'is-invalid' : '' }}" name="talk_type" id="talk_type">
                                            <option value="1" {{ old('talk_type') == App\Entity\TalkTypes::VOICE_CALL ? 'selected' : '' }}> Phone</option>
                                            <option value="2" selected> Video</option>
                                        </select>
                                        @if($errors->has('talk_type'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('talk_type') }}
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.talk_type_helper') }}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="call_type">{{ trans('cruds.socketRoomsAdmin.fields.call_type') }}</label>
                                        <select class="form-control {{ $errors->has('call_type') ? 'is-invalid' : '' }}" name="call_type" id="call_type">
                                            <option value="1" {{ old('call_type') == App\Entity\CallTypes::ONE_TO_ONE ? 'selected' : '' }}> 1 to 1</option>
                                            <option value="2" {{ old('call_type') == App\Entity\CallTypes::GROUP ? 'selected' : '' }}> Group</option>
                                            <option></option>
                                        </select>
                                        @if($errors->has('call_type'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('call_type') }}
                                            </div>
                                        @endif
                                        <div class="d-none validation_message"></div>
                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.call_type_helper') }}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="call_type">{{ trans('cruds.socketRoomsAdmin.fields.anonymous') }}</label>
                                        <select class="form-control" name="anonym" id="anonym">
                                            <option value="{{ \App\Models\Booking::ANONYM['not_anonym'] }}" @if ($talks->first()->anonym_call == \App\Models\Talk::ANONYM_CALL['not_allowed']) selected @endif>No</option>
                                            <option value="{{ \App\Models\Booking::ANONYM['anonym'] }}" @if ($talks->first()->anonym_call == \App\Models\Talk::ANONYM_CALL['allowed']) selected @endif>Yes</option>
                                        </select>
                                        @if($errors->has('call_type'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('call_type') }}
                                            </div>
                                        @endif
                                        <div class="d-none validation_message"></div>
                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.call_type_helper') }}</small>
                                    </div>
                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <label for="extendable">{{ trans('cruds.socketRoomsAdmin.fields.extendable') }}</label>--}}
                                    {{--                                        <select class="form-control {{ $errors->has('extendable') ? 'is-invalid' : '' }}" name="extendable" id="extendable">--}}
                                    {{--                                            <option value="0" {{ old('extendable') == 0 ? 'selected' : '' }}> Yes </option>--}}
                                    {{--                                            <option value="1" {{ old('extendable') == 1 ? 'selected' : '' }}> No </option>--}}
                                    {{--                                        </select>--}}
                                    {{--                                        @if($errors->has('extendable'))--}}
                                    {{--                                            <div class="invalid-feedback">--}}
                                    {{--                                                {{ $errors->first('extendable') }}--}}
                                    {{--                                            </div>--}}
                                    {{--                                        @endif--}}
                                    {{--                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.extendable_helper') }}</small>--}}
                                    {{--                                    </div>--}}
                                    @php
                                        $durations = [5, 10, 15, 30, 45, 60, 120];
                                    @endphp
                                    <div class="form-group">
                                        <label for="duration">{{ trans('cruds.socketRoomsAdmin.fields.duration') }}</label>
                                        <select class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" name="duration" id="duration">
                                            @foreach($durations as $duration)
                                                <option value="{{ $duration }}" {{ (old('duration') == $duration) || $talks->first()->duration == $duration ? 'selected' : '' }}>{{ $duration }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('duration'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('duration') }}
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.duration_helper') }}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="appt">{{ trans('cruds.socketRoomsAdmin.fields.date') }}</label>
                                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                            <input type="text"
                                                   id="date"
                                                   placeholder="Date"
                                                   name="start_call"
                                                   title="Date"
                                                   class="form-control datetimepicker-input"
                                                   data-toggle="datetimepicker"
                                                   data-target="#date"
                                            >
                                        </div>
                                        <div class="d-none validation_message"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="appt">{{ trans('cruds.socketRoomsAdmin.fields.time') }}</label>
                                        <div class="input-group time" id="reservationtime" data-target-input="nearest">
                                            <input type="text"
                                                   id="time"
                                                   placeholder="Time"
                                                   name="start_call_time"
                                                   title="Time"
                                                   class="form-control datetimepicker-input"
                                                   data-toggle="datetimepicker"
                                                   data-target="#time"
                                            >
                                        </div>
                                        <div class="d-none validation_message"></div>
                                    </div>

                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <label class="required" for="state">{{ trans('cruds.socketRoomsAdmin.fields.state') }}</label>--}}
                                    {{--                                        <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state" value="{{ old('state', '') }}" required>--}}
                                    {{--                                        @if($errors->has('state'))--}}
                                    {{--                                            <div class="invalid-feedback">--}}
                                    {{--                                                {{ $errors->first('state') }}--}}
                                    {{--                                            </div>--}}
                                    {{--                                        @endif--}}
                                    {{--                                        <div class="d-none validation_message"></div>--}}
                                    {{--                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.state_helper') }}</small>--}}
                                    {{--                                    </div>--}}

                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <label class="required" for="state">{{ trans('cruds.socketRoomsAdmin.fields.host') }}</label>--}}
                                    {{--                                        <textarea class="form-control {{ $errors->has('host') ? 'is-invalid' : '' }}" type="text" name="host" id="host" value="{{ old('host', '') }}" required></textarea>--}}
                                    {{--                                        @if($errors->has('host'))--}}
                                    {{--                                            <div class="invalid-feedback">--}}
                                    {{--                                                {{ $errors->first('host') }}--}}
                                    {{--                                            </div>--}}
                                    {{--                                        @endif--}}
                                    {{--                                        <div class="d-none validation_message"></div>--}}
                                    {{--                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.host_helper') }}</small>--}}
                                    {{--                                    </div>--}}


                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <label class="required" for="state">{{ trans('cruds.socketRoomsAdmin.fields.attendees') }}</label>--}}
                                    {{--                                        <textarea class="form-control {{ $errors->has('attendees') ? 'is-invalid' : '' }}" type="text" name="attendees" id="attendees" value="{{ old('attendees', '') }}" required></textarea>--}}
                                    {{--                                        @if($errors->has('attendees'))--}}
                                    {{--                                            <div class="invalid-feedback">--}}
                                    {{--                                                {{ $errors->first('attendees') }}--}}
                                    {{--                                            </div>--}}
                                    {{--                                        @endif--}}
                                    {{--                                        <div class="d-none validation_message"></div>--}}
                                    {{--                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.attendees_helper') }}</small>--}}
                                    {{--                                    </div>--}}

                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <label class="required" for="room_status">{{ trans('cruds.socketRoomsAdmin.fields.room_status') }}</label>--}}
                                    {{--                                        <input class="form-control {{ $errors->has('room_status') ? 'is-invalid' : '' }}" type="text" name="room_status" id="room_status" value="{{ old('room_status', '') }}" required>--}}
                                    {{--                                        @if($errors->has('room_status'))--}}
                                    {{--                                            <div class="invalid-feedback">--}}
                                    {{--                                                {{ $errors->first('room_status') }}--}}
                                    {{--                                            </div>--}}
                                    {{--                                        @endif--}}
                                    {{--                                        <div class="d-none validation_message"></div>--}}
                                    {{--                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.state_helper') }}</small>--}}
                                    {{--                                    </div>--}}

                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <label for="participiants">{{ trans('cruds.socketRoomsAdmin.fields.participiants') }}</label>--}}
                                    {{--                                        <select class="form-control {{ $errors->has('participiants') ? 'is-invalid' : '' }}" name="participiants" id="participiants">--}}
                                    {{--                                            <option value="0" {{ old('participiants') == 0 ? 'selected' : '' }}> Fake user </option>--}}
                                    {{--                                            <option value="1" {{ old('participiants') == 1 ? 'selected' : '' }}> Real user </option>--}}
                                    {{--                                        </select>--}}
                                    {{--                                        @if($errors->has('participiants'))--}}
                                    {{--                                            <div class="invalid-feedback">--}}
                                    {{--                                                {{ $errors->first('participiants') }}--}}
                                    {{--                                            </div>--}}
                                    {{--                                        @endif--}}
                                    {{--                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.participiants_helper') }}</small>--}}
                                    {{--                                    </div>--}}

                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <label for="test_call">{{ trans('cruds.socketRoomsAdmin.fields.test_call') }}</label>--}}
                                    {{--                                        <select class="form-control {{ $errors->has('test_call') ? 'is-invalid' : '' }}" name="test_call" id="test_call">--}}
                                    {{--                                            <option value="0" {{ old('test_call') == 0 ? 'selected' : '' }}> No </option>--}}
                                    {{--                                            <option value="1" {{ old('test_call') == 1 ? 'selected' : '' }}> Yes </option>--}}
                                    {{--                                        </select>--}}
                                    {{--                                        @if($errors->has('test_call'))--}}
                                    {{--                                            <div class="invalid-feedback">--}}
                                    {{--                                                {{ $errors->first('test_call') }}--}}
                                    {{--                                            </div>--}}
                                    {{--                                        @endif--}}
                                    {{--                                        <small class="form-text text-muted">{{ trans('cruds.socketRoomsAdmin.fields.call_type_helper') }}</small>--}}
                                    {{--                                    </div>--}}

                                    <div class="form-group users-single">
                                        <label for="fake_user_id">{{ trans('cruds.socketRoomsAdmin.fields.participiants_fake') }}</label>
                                        <select class="selectpicker form-control" data-live-search="true" data-size="10" id="fake_user_id" name="fake_user_id" required>
                                            @foreach($participants as $participant)
                                                <option value="{{$participant->id}}">{{ $participant->name }} - {{ $participant->email }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group users-multiple" style="display: none">
                                        <label for="fake_user_id">{{ trans('cruds.socketRoomsAdmin.fields.participiants_fake') }}</label>
                                        <select class="selectpicker-multiple form-control" data-live-search="true" data-size="10" id="fake_user_id" name="fake_user_id[]" required multiple>
                                            @foreach($participants as $participant)
                                                <option value="{{$participant->id}}">{{ $participant->name }} - {{ $participant->email }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span style="display: block;" id="create-test-room-submit" class="btn btn-success btn-block btn-lg mt-3">{{ trans('cruds.socketRoomsAdmin.fields.create_room') }}</span>
                                    </div>
                                </div>

                            </form>

                            <!-- /.Form -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript">

		(function () {
			var dateToday = new Date();

			$('#date').datetimepicker({
				format     : 'YYYY/MM/DD',
				minDate    : dateToday,
				defaultDate: dateToday,
				icons      : {
					time: 'fas fa-clock',
					date: 'fas fa-calendar',
					up  : 'fas fa-arrow-up',
					down: 'fas fa-arrow-down',
				},
			});

			$('#time').datetimepicker({
				format: 'HH:mm',
				// stepping: 15,
                {{--  defaultDate: '{{ date('H:i') }}', --}}
				icons: {
					time: 'fas fa-clock',
					date: 'fas fa-calendar',
					up  : 'fas fa-arrow-up',
					down: 'fas fa-arrow-down',
				},
			});

			$.extend(true, $.fn.datetimepicker.defaults, {
				icons: {
					time    : 'far fa-clock',
					date    : 'far fa-calendar',
					up      : 'fas fa-arrow-up',
					down    : 'fas fa-arrow-down',
					previous: 'fas fa-chevron-left',
					next    : 'fas fa-chevron-right',
					today   : 'fas fa-calendar-check',
					clear   : 'far fa-trash-alt',
					close   : 'far fa-times-circle',
				},
                {{-- defaultDate: '{{ now()->format('d/m/Y') }}', --}}
			});

			let row_number = 1;
			$('#add_row').click(function (e) {
				e.preventDefault();
				let new_row_number = row_number - 1;
				$('#tableRow' + row_number).html($('#tableRow' + new_row_number).html()).find('td:first-child');
				$('#table').append('<tr id="tableRow' + (row_number + 1) + '"></tr>');
				row_number++;
			});
			$('#delete_row').click(function (e) {
				e.preventDefault();
				if (row_number > 1) {
					$('#tableRow' + (row_number - 1)).html('');
					row_number--;
				}
			});

			document.getElementById('create-test-room-submit').addEventListener('click', validateCreateTestRoomForm);
			// document.getElementById("room_name").addEventListener("input", onInputRoomName)
			document.getElementById('reservationdatetime').getElementsByTagName('input')[0].addEventListener('input', onInputDateValidation);
			// document.getElementById("state").addEventListener("input", onInputState)
			// document.getElementById("host").addEventListener("input", onInputHost)
			// document.getElementById("attendees").addEventListener("input", onInputAttendees)
			// document.getElementById("room_status").addEventListener("input", onInputRoomStatus)
			document.getElementById('talk_id').addEventListener('change', onInputRoomTalkId);
		})();

		let errors      = [];
		let dateTimeNow = new Date();

		function validateCreateTestRoomForm() {
			// let room_name           = document.getElementById("room_name");
			let reservationdatetime = document.getElementById('reservationdatetime');
			// let state               = document.getElementById("state");
			// let host                = document.getElementById("host");
			// let attendees           = document.getElementById("attendees");
			// let room_status         = document.getElementById("room_status");
			let talk_id = document.getElementById('talk_id');

			// if (room_name.value.length > 4) {
			//     room_name.style.border = '1px solid #ced4da';
			//     room_name.style.color = '#495057';
			//     if (!room_name.parentElement.getElementsByClassName("validation_message")[0].classList.contains("d-none")) {
			//         room_name.parentElement.getElementsByClassName("validation_message")[0].classList.add("d-none");
			//     }
			//
			//     let index = errors.indexOf("Room name is required and must be longer than 4 characters.");
			//     if (index > -1) {
			//         errors.splice(index, 1);
			//     }
			// } else {
			//     room_name.style.border = '1px solid red';
			//     room_name.style.color = 'red';
			//     room_name.parentElement.getElementsByClassName("validation_message")[0].textContent = 'Room name is required and must be longer than 4 characters.';
			//     room_name.parentElement.getElementsByClassName("validation_message")[0].classList.remove("d-none");
			//     if (!errors.includes("Room name is required and must be longer than 4 characters.")) {
			//         errors.push('Room name is required and must be longer than 4 characters.');
			//     }
			// }

			// if (!state.value.length == 0 && !isNaN(state.value) && state.value < 128) {
			//     state.style.border = '1px solid #ced4da';
			//     state.style.color = '#495057';
			//     if (!state.parentElement.getElementsByClassName("validation_message")[0].classList.contains("d-none")) {
			//         state.parentElement.getElementsByClassName("validation_message")[0].classList.add("d-none");
			//     }
			//
			//     let index = errors.indexOf("State is required and must be number (max 127).");
			//     if (index > -1) {
			//         errors.splice(index, 1);
			//     }
			// } else {
			//     state.style.border = '1px solid red';
			//     state.style.color = 'red';
			//     state.parentElement.getElementsByClassName("validation_message")[0].textContent = 'State is required and must be number (max 127).';
			//     state.parentElement.getElementsByClassName("validation_message")[0].classList.remove("d-none");
			//     if (!errors.includes("State is required and must be number (max 127).")) {
			//         errors.push("State is required and must be number (max 127).");
			//     }
			// }
			//
			// if (host.value.length  > 4) {
			//     host.style.border = '1px solid #ced4da';
			//     host.style.color = '#495057';
			//     if (!host.parentElement.getElementsByClassName("validation_message")[0].classList.contains("d-none")) {
			//         host.parentElement.getElementsByClassName("validation_message")[0].classList.add("d-none");
			//     }
			//
			//     let index = errors.indexOf("Host is required and must be longer than 4 characters.");
			//     if (index > -1) {
			//         errors.splice(index, 1);
			//     }
			// } else {
			//     host.style.border = '1px solid red';
			//     host.style.color = 'red';
			//     host.parentElement.getElementsByClassName("validation_message")[0].textContent = 'Host is required and must be longer than 4 characters.';
			//     host.parentElement.getElementsByClassName("validation_message")[0].classList.remove("d-none");
			//     if (!errors.includes("Host is required and must be longer than 4 characters.")) {
			//         errors.push("Host is required and must be longer than 4 characters.");
			//     }
			// }
			//
			// if (attendees.value.length  > 4) {
			//     attendees.style.border = '1px solid #ced4da';
			//     attendees.style.color = '#495057';
			//     if (!attendees.parentElement.getElementsByClassName("validation_message")[0].classList.contains("d-none")) {
			//         attendees.parentElement.getElementsByClassName("validation_message")[0].classList.add("d-none");
			//     }
			//
			//     let index = errors.indexOf("Attendees is required and must be longer than 4 characters.");
			//     if (index > -1) {
			//         errors.splice(index, 1);
			//     }
			// } else {
			//     attendees.style.border = '1px solid red';
			//     attendees.style.color = 'red';
			//     attendees.parentElement.getElementsByClassName("validation_message")[0].textContent = 'Attendees is required and must be longer than 4 characters.';
			//     attendees.parentElement.getElementsByClassName("validation_message")[0].classList.remove("d-none");
			//     if (!errors.includes("Attendees is required and must be longer than 4 characters.")) {
			//         errors.push("Attendees is required and must be longer than 4 characters.");
			//     }
			// }

			// if (!room_status.value.length == 0 && !isNaN(room_status.value) && room_status.value < 128) {
			//     room_status.style.border = '1px solid #ced4da';
			//     room_status.style.color = '#495057';
			//     if (!room_status.parentElement.getElementsByClassName("validation_message")[0].classList.contains("d-none")) {
			//         room_status.parentElement.getElementsByClassName("validation_message")[0].classList.add("d-none");
			//     }
			//
			//     let index = errors.indexOf("Room Status is required and must be number (max 127).");
			//     if (index > -1) {
			//         errors.splice(index, 1);
			//     }
			// } else {
			//     room_status.style.border = '1px solid red';
			//     room_status.style.color = 'red';
			//     room_status.parentElement.getElementsByClassName("validation_message")[0].textContent = 'Room Status is required and must be number (max 127).';
			//     room_status.parentElement.getElementsByClassName("validation_message")[0].classList.remove("d-none");
			//     if (!errors.includes("Room Status is required and must be number (max 127).")) {
			//         errors.push("Room Status is required and must be number (max 127).");
			//     }
			// }

			if (! talk_id.value == 0) {
				talk_id.parentElement.style.border = '1px solid #ced4da';
				talk_id.style.color                = '#495057';
				if (! talk_id.parentElement.parentElement.getElementsByClassName('validation_message')[0].classList.contains('d-none')) {
					talk_id.parentElement.parentElement.getElementsByClassName('validation_message')[0].classList.add('d-none');
				}

				let index = errors.indexOf('Talk ID is required, please select.');
				if (index > -1) {
					errors.splice(index, 1);
				}
			} else {
				talk_id.parentElement.style.border                                                              = '1px solid red';
				talk_id.parentElement.getElementsByClassName('btn dropdown-toggle btn-light')[0].style.color    = 'red';
				talk_id.parentElement.parentElement.getElementsByClassName('validation_message')[0].textContent = 'Talk is required, please select.';
				talk_id.parentElement.parentElement.getElementsByClassName('validation_message')[0].classList.remove('d-none');
				if (! errors.includes('Talk is required, please select.')) {
					errors.push('Talk is required, please select.');
				}
			}

			if (! errors.length) {
				document.getElementById('form-test-room').submit();
			}

		}

		function onInputRoomName(e) {

			if (e.currentTarget.value.length > 4) {
				e.currentTarget.style.border = '1px solid #ced4da';
				e.currentTarget.style.color  = '#495057';
				if (! e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.contains('d-none')) {
					e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.add('d-none');
				}
				let index = errors.indexOf('Room name is required and must be longer than 4 characters.');
				if (index > -1) {
					errors.splice(index, 1);
				}

			} else {
				e.currentTarget.style.border                                                              = '1px solid red';
				e.currentTarget.style.color                                                               = 'red';
				e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].textContent = 'Room name is required and must be longer than 4 characters.';
				e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.remove('d-none');
				if (! errors.includes('Room name is required and must be longer than 4 characters.')) {
					errors.push('Room name is required and must be longer than 4 characters.');
				}
			}
		}

		function onInputDateValidation(e) {

			let dateTimeSelected = new Date(document.getElementById('reservationdatetime').getElementsByTagName('input')[0].value);

			if (dateTimeNow < dateTimeSelected) {

				e.currentTarget.style.border = '1px solid #ced4da';
				e.currentTarget.classList.remove('red-color');
				if (! e.currentTarget.parentElement.parentElement.getElementsByClassName('validation_message')[0].classList.contains('d-none')) {
					e.currentTarget.parentElement.parentElement.getElementsByClassName('validation_message')[0].classList.add('d-none');
				}
				let index = errors.indexOf('Time can not be in the past.');
				if (index > -1) {
					errors.splice(index, 1);
				}
			} else {
				e.currentTarget.style.border = '1px solid red';
				e.currentTarget.classList.add('red-color');
				e.currentTarget.parentElement.parentElement.getElementsByClassName('validation_message')[0].textContent = 'Time can not be in the past.';
				e.currentTarget.parentElement.parentElement.getElementsByClassName('validation_message')[0].classList.remove('d-none');
				if (! errors.includes('Time can not be in the past.')) {
					errors.push('Time can not be in the past.');
				}
			}

		}

		function onInputState(e) {

			if (! isNaN(e.currentTarget.value) && e.currentTarget.value < 128) {
				e.currentTarget.style.border = '1px solid #ced4da';
				e.currentTarget.style.color  = '#495057';
				if (! e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.contains('d-none')) {
					e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.add('d-none');
				}
				let index = errors.indexOf('State is required and must be number (max 127).');
				if (index > -1) {
					errors.splice(index, 1);
				}

			} else {
				e.currentTarget.style.border                                                              = '1px solid red';
				e.currentTarget.style.color                                                               = 'red';
				e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].textContent = 'State is required and must be number (max 127).';
				e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.remove('d-none');
				if (! errors.includes('State is required and must be number (max 127).')) {
					errors.push('State is required and must be number (max 127).');
				}
			}

		}

		function onInputHost(e) {

			if (e.currentTarget.value.length > 4) {
				e.currentTarget.style.border = '1px solid #ced4da';
				e.currentTarget.style.color  = '#495057';
				if (! e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.contains('d-none')) {
					e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.add('d-none');
				}
				let index = errors.indexOf('State is required and must be number (max 127).');
				if (index > -1) {
					errors.splice(index, 1);
				}

			} else {
				e.currentTarget.style.border                                                              = '1px solid red';
				e.currentTarget.style.color                                                               = 'red';
				e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].textContent = 'Host is required and must be longer than 4 characters.';
				e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.remove('d-none');
				if (! errors.includes('Host is required and must be longer than 4 characters.')) {
					errors.push('Host is required and must be longer than 4 characters.');
				}
			}

		}

		function onInputAttendees(e) {

			if (e.currentTarget.value.length > 4) {
				e.currentTarget.style.border = '1px solid #ced4da';
				e.currentTarget.style.color  = '#495057';
				if (! e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.contains('d-none')) {
					e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.add('d-none');
				}
				let index = errors.indexOf('Attendees is required and must be number (max 127).');
				if (index > -1) {
					errors.splice(index, 1);
				}

			} else {
				e.currentTarget.style.border                                                              = '1px solid red';
				e.currentTarget.style.color                                                               = 'red';
				e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].textContent = 'Attendees is required and must be longer than 4 characters.';
				e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.remove('d-none');
				if (! errors.includes('Attendees is required and must be longer than 4 characters.')) {
					errors.push('Attendees is required and must be longer than 4 characters.');
				}
			}

		}

		function onInputRoomStatus(e) {

			if (! isNaN(e.currentTarget.value) && e.currentTarget.value < 128) {
				e.currentTarget.style.border = '1px solid #ced4da';
				e.currentTarget.style.color  = '#495057';
				if (! e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.contains('d-none')) {
					e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.add('d-none');
				}
				let index = errors.indexOf('Attendees is required and must be number (max 127).');
				if (index > -1) {
					errors.splice(index, 1);
				}

			} else {
				e.currentTarget.style.border                                                      = '1px solid red';
				e.currentTarget.style.color                                                       = 'red';
				e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].ent = 'Attendees is required and must be longer than 4 characters.';
				e.currentTarget.parentElement.getElementsByClassName('validation_message')[0].classList.remove('d-none');
				if (! errors.includes('Attendees is required and must be longer than 4 characters.')) {
					errors.push('Attendees is required and must be longer than 4 characters.');
				}
			}

		}

		function onInputRoomTalkId(e) {

			if (! e.currentTarget.value == 0) {
				e.currentTarget.parentElement.style.border                                                           = '1px solid #ced4da';
				e.currentTarget.parentElement.getElementsByClassName('btn dropdown-toggle btn-light')[0].style.color = '#495057';
				if (! e.currentTarget.parentElement.parentElement.getElementsByClassName('validation_message')[0].classList.contains('d-none')) {
					e.currentTarget.parentElement.parentElement.getElementsByClassName('validation_message')[0].classList.add('d-none');
				}

				let index = errors.indexOf('Talk is required, please select.');
				if (index > -1) {
					errors.splice(index, 1);
				}
			} else {
				e.currentTarget.parentElement.style.border                                                           = '1px solid red';
				e.currentTarget.parentElement.getElementsByClassName('btn dropdown-toggle btn-light')[0].style.color = 'red';
				e.currentTarget.parentElement.parentElement.getElementsByClassName('validation_message')[0].ent      = 'Talk is required, please select.';
				e.currentTarget.parentElement.parentElement.getElementsByClassName('validation_message')[0].classList.remove('d-none');
				if (! errors.includes('Talk is required, please select.')) {
					errors.push('Talk is required, please select.');
				}

			}

		}

		$(function () {
			var supplier_id = '{{ $supplier_id ?? null}}';

			$(document).delegate('#teacher', 'change', function () {
				let teacherId = $(this).val();
				populateDataListSuppliers(teacherId);
			});

			function populateDataListSuppliers(teacherId) {
				$.ajax({
					url   : '{{ route('admin.socket-rooms.talksSelectList') }}',
					method: 'GET',
					data  : { teacherId: teacherId },
				}).done(function (response) {
					$('#talksHolder').show();

					$('#talksSelectHolder').html(response.html);

					changeTalkData($('#talksSelectHolder')[0].querySelector('select'));

				}).fail(function (xhr, text) {
					console.log('error', text);
				});
			}

			populateDataListSuppliers('{{ $suppliers[0]['id'] }}');
		});
    </script>
    <!-- Talk Switch -->
    <script>
		const anonymSelect        = document.querySelector('#anonym');
		const durationSelect      = document.querySelector('#duration');
		const callTypeSelect      = document.querySelector('#call_type');
		const usersSelect         = document.querySelector('.users-single');
		const usersSelectMultiple = document.querySelector('.users-multiple');

		callTypeSelect.addEventListener('change', function () {
			let selectedOption = callTypeSelect.options[callTypeSelect.selectedIndex].value;

			switch (parseInt(selectedOption)) {
				case {{ \App\Entity\CallTypes::ONE_TO_ONE }}:
					callTypeSelect.disabled = false;
					usersSelect.style.removeProperty('display');
					usersSelectMultiple.style.display = 'none';
					Array.from(usersSelectMultiple.querySelector('select').options).forEach(option => option.selected = false);

					break;
				case {{ \App\Entity\CallTypes::GROUP }}:
					usersSelect.style.display = 'none';
					usersSelectMultiple.style.removeProperty('display');
			}
		});

		function changeTalkData(data) {
			let option         = data.options[data.selectedIndex];
			let duration       = option.getAttribute('data-duration');
			let callType       = option.getAttribute('data-call-type');
			let selectedOption = Array.from(durationSelect.options).filter(option => option.value == duration);

			switch (parseInt(callType)) {
				case {{ \App\Entity\CallTypes::ONE_TO_ONE }}:
					callTypeSelect.disabled            = false;
					callTypeSelect.options[0].selected = true;
					usersSelect.style.removeProperty('display');
					usersSelectMultiple.style.display = 'none';
					Array.from(usersSelectMultiple.querySelector('select').options).forEach(option => option.selected = false);

					break;
				case {{ \App\Entity\CallTypes::GROUP }}:
					callTypeSelect.disabled            = true;
					callTypeSelect.options[1].selected = true;
					usersSelect.style.display          = 'none';
					usersSelectMultiple.style.removeProperty('display');
			}

			durationSelect.selectedIndex = selectedOption[0].index;
		}
    </script>

    <!-- Server and Client Times -->
    <script>
		// Selectors
		let timezoneOffset = document.querySelector('#timezone_offset');
		let timeInput      = document.querySelector('#time');
		timeInput.value    = pad(today.getHours()) + ':' + pad(today.getMinutes());

		/**
		 * Add leading zero to the number.
		 *
		 * @param { Integer } value Number to be padded.
		 *
		 * @returns { String|Integer }
		 */
		function pad(value) {
			return ((value < 10) ? '0' : '') + value;
		}

		// At the moment, timezone offset is being reverted within Booking controller.
		timezoneOffset.value = new Date().getTimezoneOffset();
    </script>
@endsection
