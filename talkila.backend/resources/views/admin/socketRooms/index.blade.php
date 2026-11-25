@extends('layout.mainlayout')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h5>{{ trans('cruds.socketRooms.title') }}</h5>
            </div>

            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="{{ route('admin.socket-rooms.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.socketRooms.title_singular') }}
                    </a>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-SocketRooms">
                <thead>
                    <tr>
                        <th style="max-width: 75px">
                            {{ trans('cruds.socketRooms.fields.socket_id') }}
                        </th>
                        <th>
                            {{ trans('cruds.socketRooms.fields.room_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.socketRooms.fields.start_call') }}
                        </th>
                        <th>
                            {{ trans('cruds.socketRooms.fields.end_call') }}
                        </th>
                        <th>
                            {{ trans('cruds.socketRooms.fields.talk_duration') }}
                        </th>
                        <th>
                            {{ trans('cruds.socketRooms.fields.call_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.socketRooms.fields.teacher_joined') }}
                        </th>
                        <th>
                            {{ trans('cruds.socketRooms.fields.student_joined') }}
                        </th>
                        <th>
                            {{ trans('cruds.socketRooms.fields.state') }}
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
{{--                        <td>--}}
{{--                            <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                        </td>--}}
                        <td>
                            <select class="form-control" name="duration" id="duration">
                                <option value>- -</option>
                                @foreach($durations as $duration)
                                    <option value="{{ $duration }}">{{ $duration }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="talk_type" id="talk_type">
                                <option value>- -</option>
                                <option value="{{ CallTypes::ONE_TO_ONE }}">Private</option>
                                <option value="{{ CallTypes::GROUP }}">Group</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="teacher_joined" id="teacher_joined">
                                <option value>- -</option>
                                <option value="0">no</option>
                                <option value="1">yes</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="student_joined" id="student_joined">
                                <option value>- -</option>
                                <option value="0">no</option>
                                <option value="1">yes</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="state" id="state">
                                <option value>- -</option>
                                <option value="1">pending</option>
                                <option value="2">room successfully closed</option>
                                <option value="3">teacher cancelled room</option>
                                <option value="4">teacher didnt join</option>
                            </select>
                        </td>
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
                ajax         : "{{ route('admin.socket-rooms.index') }}",
                columns      : [
                    {
                        name: 'id',
                        data: function (data, type, row) {
                            return '<a class="link" href="socket-rooms/' + data.id + '">' + data.id + '</a>';
                        },
                    },
                    {
                        name: 'room_name',
                        data: function (data, type, row) {
                            return '<a class="link" href="socket-rooms/' + data.id + '">' + data.room_name + '</a>';
                        },
                    },
                    { data: 'talk_start_time', name: 'talk_start_time' },
                    { data: 'talk_end_time', name: 'talk_end_time' },
                    { data: 'duration' },
                    {
                        data  : 'call_type',
                        render: function (data) {
                            switch (data) {
                                case {{ CallTypes::ONE_TO_ONE }}:
                                    return 'Private';
                                case {{ CallTypes::GROUP }}:
                                    return 'Group';
                                default:
                                    return '';
                            }
                        },
                    },
                    {
                        data  : 'teacher_joined',
                        render: function (data) {
                            switch (data) {
                                case 0:
                                    return '<span class="danger-color">no</span>';
                                case 1:
                                    return '<span class="success-color">yes</span>';
                                default:
                                    return '';
                            }
                        },
                    },
                    {
                        data  : 'student_joined',
                        render: function (data) {
                            switch (data) {
                                case 0:
                                    return '<span class="danger-color">no</span>';
                                case 1:
                                    return '<span class="success-color">yes</span>';
                                default:
                                    return '';
                            }
                        },
                    },
                    {
                        data  : 'state',
                        render: function (data) {
                            switch (data) {
                                case {{ RoomStates::ROOM_PENDING }}:
                                    return '<span class="success-color">pending</span>';
                                case {{ RoomStates::ROOM_DONE }}:
                                    return '<span class="success-color">room successfully closed</span>';
                                case {{ RoomStates::TEACHER_CANCELLED }}:
                                    return '<span class="danger-color">teacher cancelled room</span>';
                                case {{ RoomStates::TEACHER_DONT_SHOW }}:
                                    return '<span class="danger-color">teacher didnt join</span>';
                                case {{ RoomStates::ROOM_IN_PROGRESS }}:
                                    return '<span class="success-color">room in progress</span>';
                                case {{ RoomStates::STUDENT_DONT_SHOW }}:
                                    return '<span class="danger-color">student didnt join</span>';
                                default:
                                    return 'Undefined';
                            }
                        },
                    },
                ],
                orderCellsTop: true,
                order        : [[0, 'desc']],
                pageLength   : 100,
            };
            let table             = $('.datatable-SocketRooms').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                                              .columns.adjust();
            });
            $('.datatable-SocketRooms thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw();
            });
            $('.datatable-SocketRooms thead select').on('change', function () {
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