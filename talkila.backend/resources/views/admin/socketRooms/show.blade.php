@extends('layout.mainlayout')
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>{{ trans('cruds.socketRooms.title') }} - ({{ $socketRoom->id }}) - {{ $socketRoom->room_name }}</h5>
                    </div>
                    <div class="col-sm-8">
                        <div class="state-box">
                            @if($socketRoom->state)
                                @if($socketRoom->state === 1)
                                    <h2 class="success-color">PENDING</h2>
                                @elseif($socketRoom->state === 2)
                                    <h2 class="success-color">ROOM SUCCESSFULLY CLOSED</h2>
                                @elseif($socketRoom->state === 3)
                                    <h2 class="danger-color">TEACHER CANCELLED ROOM</h2>
                                @elseif($socketRoom->state === 4)
                                    <h2 class="danger-color">TEACHER DIDNT JOIN</h2>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <table class=" table table-bordered table-striped table-hover">
                <tbody>
                    <tr>
                        <td>
                            {{ trans('cruds.socketRooms.fields.socket_id') }}
                        </td>
                        <td>
                            {{ $socketRoom->id }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cruds.socketRooms.fields.talk_name') }}
                        </td>
                        <td>
                            {{ $socketRoom->room_name }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('global.price') }}
                        </td>
                        <td>
                            {{ $socketRoom->talk->price }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cruds.talk.fields.duration') }}
                        </td>
                        <td>
                            {{ $socketRoom->duration }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cruds.socketRooms.fields.talk_start') }}
                        </td>
                        <td>
                            {{ $socketRoom->talk_start_time }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cruds.socketRooms.fields.talk_end') }}
                        </td>
                        <td>
                            {{ $socketRoom->talk_end_time }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cruds.socketRooms.fields.talk_type') }}
                        </td>
                        <td>
                            {{ $socketRoom->talk_type === TalkTypes::VOICE_CALL ? 'Voice' : 'Video' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cruds.talk.fields.call_type') }}
                        </td>
                        <td>
                            {{ $socketRoom->call_type === \App\Entity\CallTypes::ONE_TO_ONE ? 'Private' : 'Group'  }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cruds.socketRooms.fields.teacher_joined') }}
                        </td>
                        <td>
                            {{ $socketRoom->teacher_joined ? 'Teacher did join' : 'Teacher did not join' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cruds.socketRooms.fields.student_joined') }}
                        </td>
                        <td>
                            {{ $socketRoom->student_joined ? 'Student did join' : 'Student did not join' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cruds.socketRooms.fields.call_extended') }}
                        </td>
                        <td>
                            {{ $socketRoom->call_extended ? 'Call was extended' : 'Call was not extended'  }}
                        </td>
                    </tr>
                </tbody>
            </table>
            </br>

            <!-- Participiants -->
            <h3>{{ $totalParticipiants }} {{ trans('cruds.socketRooms.fields.participiants') }}</h3>
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-SocketParticipants">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.user.title_singular') }}
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.username') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.firebase_token') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.is_active') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.is_anonym') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.device_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.device_model') }}
                        </th>
                        <th>
                            {{ trans('cruds.socketRooms.fields.room_joined') }}
                        </th>
                        <th>
                            {{ trans('cruds.socketRooms.fields.room_end') }}
                        </th>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <select class="form-control" name="name_of_user" id="name_of_user">
                                <option value>- -</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->name_of_user }}">{{ $user->name_of_user }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <select class="form-control" name="talk_type" id="talk_type">
                                <option value>- -</option>
                                <option value="0">no</option>
                                <option value="1">yes</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="talk_type" id="talk_type">
                                <option value>- -</option>
                                <option value="0">no</option>
                                <option value="1">yes</option>
                            </select>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
            </table>
            </br>

            <!-- Events -->
            <h3>{{ $totalEvents }} {{ trans('cruds.socketRooms.fields.events') }}</h3>
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-SocketEvents">
                <thead>
                    <tr>
                        {{--                        <th>ID</th>--}}
                        {{--                        <th>--}}
                        {{--                            {{ trans('cruds.user.title_singular') }}--}}
                        {{--                            {{ trans('cruds.user.fields.id') }}--}}
                        {{--                        </th>--}}
                        {{--                        <th>--}}
                        {{--                            {{ trans('cruds.user.fields.username') }}--}}
                        {{--                        </th>--}}
                        {{--                        <th>--}}
                        {{--                            {{ trans('cruds.socketRooms.fields.event') }}--}}
                        {{--                        </th>--}}
                        {{--                        <th>--}}
                        {{--                            {{ trans('cruds.socketRooms.fields.data') }}--}}
                        {{--                        </th>--}}
                        {{--                        <th>--}}
                        {{--                            {{ trans('cruds.socketRooms.fields.recieved') }}--}}
                        {{--                        </th>--}}
                        <th>ID</th>
                        <th>Supplier ID</th>
                        <th>Client ID</th>
                        <th>Supplier Username</th>
                        <th>Client Username</th>
                        <th>Supplier Event</th>
                        <th>Client Event</th>
                        <th>Supplier Data</th>
                        <th>Client Data</th>
                        <th>Supplier Received</th>
                        <th>Client Received</th>
                    </tr>
                    <tr>
                        {{--                        <td>--}}
                        {{--                        </td>--}}
                        {{--                        <td>--}}
                        {{--                        </td>--}}
                        {{--                        <td>--}}
                        {{--                            <select class="form-control" name="username" id="username">--}}
                        {{--                                <option value>- -</option>--}}
                        {{--                                @foreach($users as $user)--}}
                        {{--                                    <option value="{{ $user->name_of_user }}">{{ $user->name_of_user }}</option>--}}
                        {{--                                @endforeach--}}
                        {{--                            </select>--}}
                        {{--                        </td>--}}
                        {{--                        <td>--}}
                        {{--                            <select class="form-control" name="event" id="event">--}}
                        {{--                                <option value>- -</option>--}}
                        {{--                                <option value="1">Hangup</option>--}}
                        {{--                                <option value="2">Rejoin</option>--}}
                        {{--                            </select>--}}
                        {{--                        </td>--}}
                        {{--                        <td>--}}
                        {{--                            <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">--}}
                        {{--                        </td>--}}
                        {{--                        <td>--}}
                        {{--                        </td>--}}
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtOverrideGlobals = {
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : {
                    'type': 'GET',
                    'url' : "{{ route('admin.socket-participants.index') }}",
                    'data': { room_id: {{ $socketRoom->id }} },
                },
                columns      : [
                    {
                        data  : 'user_id',
                        render: function (data) {
                            return '<a href="' + '/users/' + data + '">' + data + '</a>';
                        },
                    },
                    {
                        data  : 'username',
                        render: function (data, type, row) {
                            return '<a href="' + '/users/' + row.user_id + '">' + data + '</a>';
                        },
                    },
                    { data: 'firebase_id', name: 'firebase_id' },
                    {
                        data  : 'is_active',
                        render: function (data) {
                            switch (data) {
                                case {{ ParticipantStates::INACTIVE }}:
                                    return 'Inactive';
                                    break;
                                case {{ ParticipantStates::JOINED }}:
                                    return 'Joined';
                                    break;
                                case {{ ParticipantStates::REJOINED }}:
                                    return 'Rejoined';
                                    break;
                                case {{ ParticipantStates::HANGUP }}:
                                    return 'Hang up';
                                    break;
                                case {{ ParticipantStates::OTHER_PERSON_HANGUP }}:
                                    return 'Other person hang up';
                                    break;
                                case {{ ParticipantStates::KICKED }}:
                                    return 'Kicked';
                                    break;
                                case {{ ParticipantStates::DIDNT_SHOW }}:
                                    return 'Didn\t show';
                                    break;
                                case {{ ParticipantStates::OTHER_PERSON_DIDNT_SHOW }}:
                                    return 'Other person didn\t show';
                                    break;
                                case {{ ParticipantStates::TIME_ENDED }}:
                                    return 'Time ended';
                                    break;
                                default:
                                    return '';
                            }
                        },
                    },
                    {
                        data  : 'is_anonym',
                        render: function (data) {
                            switch (data) {
                                case 0:
                                    return '<span class="danger-color">no</span>';
                                    break;
                                case 1:
                                    return '<span class="success-color">yes</span>';
                                    break;
                                default:
                                    return '';
                            }
                        },
                    },
                    {
                        data: 'device_type',
                        name: 'device_type',
                    },
                    {
                        data: 'device_model',
                        name: 'device_model',
                    },
                    { data: 'room_joined', name: 'room_joined' },
                    { data: 'room_end', name: 'room_end' },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-SocketParticipants').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                                              .columns.adjust();
            });
            $('.datatable-SocketParticipants thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw();
            });
            $('.datatable-SocketParticipants thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex(
                    $(this).val(),
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw();
            });
        });


        $(function () {
            let dtOverrideGlobals = {
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : {
                    'type': 'GET',
                    'url' : "{{ route('admin.socket-calls-protocol.index') }}",
                    'data': { room_id: {{ $socketRoom->id }} },
                },
                columns      : [
                    {
                        name: 'DT_RowIndex',
                        data: 'DT_RowIndex',
                    },
                    {
                        data: 'supplier_user_id',
                        render: function (data) {
                            return '<a href="' + '/users/' + data + '">' + data + '</a>';
                        },
                    },
                    {
                        data: 'client_user_id',
                        render: function (data) {
                            return '<a href="' + '/users/' + data + '">' + data + '</a>';
                        },
                    },
                    {
                        data: 'supplier_username',
                        render: function (data, type, row) {
                            return '<a href="' + '/users/' + row.participant.user_id + '">' + data + '</a>';
                        },
                    },
                    {
                        data: 'client_username',
                        render: function (data, type, row) {
                            return '<a href="' + '/users/' + row.participant.user_id + '">' + data + '</a>';
                        },
                    },
                    {
                        data: 'supplier_event',
                        name: 'supplier_event',
                    },
                    {
                        data: 'client_event',
                        name: 'client_event',
                    },
                    {
                        data: 'supplier_data',
                        name: 'supplier_data',
                    },
                    {
                        data: 'client_data',
                        name: 'client_data',
                    },
                    {
                        data: 'supplier_received',
                        name: 'supplier_received',
                    },
                    {
                        data: 'client_received',
                        name: 'client_received',
                    },
                    {{-- { --}}
                    {{--     data  : 'participant.user_id', --}}
                    {{--     render: function (data) { --}}
                    {{--         return '<a href="' + '/users/' + data + '">' + data + '</a>'; --}}
                    {{--     }, --}}
                    {{-- }, --}}
                    {{-- { --}}
                    {{--     data  : 'participant.name_of_user', --}}
                    {{--     render: function (data, type, row) { --}}
                    {{--         return '<a href="' + '/users/' + row.participant.user_id + '">' + data + '</a>'; --}}
                    {{--     }, --}}
                    {{-- }, --}}
                    {{-- { --}}
                    {{--     data  : 'event', --}}
                    {{--     render: function (data) { --}}
                    {{--         switch (data) { --}}
                    {{--             case {{ Events::UNDEFINED }}: --}}
                    {{--                 return 'Undefined'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::PICKUP }}: --}}
                    {{--                 return 'Pickup'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::HANGUP }}: --}}
                    {{--                 return 'Hangup'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::REDIAL }}: --}}
                    {{--                 return 'Redial'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::CLIENT_WAITING }}: --}}
                    {{--                 return 'Client Waiting'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::SUPPLIER_WAITING }}: --}}
                    {{--                 return 'Provider Waiting'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::TALK_END }}: --}}
                    {{--                 return 'Talk End'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::SUPPLIER_LEFT_ROOM }}: --}}
                    {{--                 return 'Teacher Left Room'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::CLIENT_LEFT_ROOM }}: --}}
                    {{--                 return 'User Left Room'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::AUDIO_OFF }}: --}}
                    {{--                 return 'Mute On'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::AUDIO_ON }}: --}}
                    {{--                 return 'Mute Off'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::VIDEO_ON }}: --}}
                    {{--                 return 'Video On'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::VIDEO_OFF }}: --}}
                    {{--                 return 'Video Off'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::SPEAKER_ON }}: --}}
                    {{--                 return 'Speaker On'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::SPEAKER_OFF }}: --}}
                    {{--                 return 'Speaker Off'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::EXTEND_CALL_TAB }}: --}}
                    {{--                 return 'Extend Call Tab'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::EXTEND_CALL_TIME_SELECTED }}: --}}
                    {{--                 return 'Extend Call Time Selected'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::EXTEND_CALL_SWIPED }}: --}}
                    {{--                 return 'Extend Call Swiped'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::EXTEND_CALL_SUCCESSFUL }}: --}}
                    {{--                 return 'Extend Call Successful'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::EXTEND_CALL_FAILURE }}: --}}
                    {{--                 return 'Extend Call Failure'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::EXTEND_CALL_ACCEPT }}: --}}
                    {{--                 return 'Extend Call Accept'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::EXTEND_CALL_REJECT }}: --}}
                    {{--                 return 'Extend Call Reject'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::EXTEND_CALL_REQUEST }}: --}}
                    {{--                 return 'Extend Call Request'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::CONNECTION_LOST }}: --}}
                    {{--                 return 'Connection Lost'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::APP_CRASH_CLIENT }}: --}}
                    {{--                 return 'App Crash Client'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::APP_CRASH_PROVIDER }}: --}}
                    {{--                 return 'App Crash Provider'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::GROUP_SUPPLIER_SET_ALL_AUDIO_OFF }}: --}}
                    {{--                 return 'Group Provider Set All Mute'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::GROUP_SUPPLIER_SET_ALL_AUDIO_ON }}: --}}
                    {{--                 return 'Group Provider Set All Unmute'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::GROUP_SUPPLIER_SET_ALL_VIDEO_OFF }}: --}}
                    {{--                 return 'Group Provider Set All Video Off'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::GROUP_SUPPLIER_SET_ALL_VIDEO_ON }}: --}}
                    {{--                 return 'Group Provider Set All Video On'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::SUPPLIER_SET_CLIENT_AUDIO_OFF }}: --}}
                    {{--                 return 'Group Provider Set Client To Mute'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::SUPPLIER_SET_CLIENT_TO_AUDIO_ON }}: --}}
                    {{--                 return 'Group Provider Set Client To Unmute'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::SUPPLIER_SET_CLIENT_VIDEO_OFF }}: --}}
                    {{--                 return 'Group Provider Set Client Video Off'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::SUPPLIER_SET_CLIENT_VIDEO_ON }}: --}}
                    {{--                 return 'Group Provider Set Client Video On'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::KICK_PARTICIPANT }}: --}}
                    {{--                 return 'Kick Participant'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::SUPPLIER_ON_HOLD }}: --}}
                    {{--                 return 'Provider On Hold'; --}}
                    {{--                 break; --}}
                    {{--             case {{ Events::SUPPLIER_ON_HOLD_BACK }}: --}}
                    {{--                 return 'Provider On Hold Back'; --}}
                    {{--                 break; --}}
                    {{--             default: --}}
                    {{--                 return ''; --}}
                    {{--         } --}}
                    {{--     }, --}}
                    {{-- }, --}}
                    {{-- { data: 'support_data', name: 'support_data' }, --}}
                    {{-- { data: 'created_at', name: 'created_at' }, --}}
                ],
                orderCellsTop: true,
                // order        : [[5, 'asc']],
                pageLength: 100,
            };
            let table             = $('.datatable-SocketEvents').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                                              .columns.adjust();
            });
            $('.datatable-SocketEvents thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw();
            });
            $('.datatable-SocketEvents thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex(
                    $(this).val(),
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw();
            });
        });
    </script>
@endsection
