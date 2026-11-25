@extends('layout.mainlayout')
@section('content')
    <h4 class="card-title">{{ trans('cruds.verifications.fields.verification_approval') }} - {{ $total }} {{ trans('cruds.verifications.fields.waiting') }}</h4>
    @if($user)
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-30">
                    <div class="card-body">
                        <div class="row height-365">
                            <div class="col-sm-8" style="height: 350px; overflow: auto">
                                <img src="{{ $user->image }}" alt="{{ $user->name }} verification image."/>
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
                                                    {{ $user->name }}
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
                                                    {{ convertToUserTimezone($user->user->created_at, 'Y-m-d H:i:s') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ trans('cruds.verifications.fields.verification_upload') }}
                                                </td>
                                                <td>
                                                    {{ $user->request_date }}
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
                <form action="{{ route('admin.profile-verifications.disapprove', ['id' => $user->id]) }}" method="POST" style="display: block;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-danger btn-block btn-lg mt-3" value="{{ trans('global.reject') }}">
                </form>
            </div>
            <div class="col-sm-4">
                <form action="{{ route('admin.profile-verifications.skip', ['id' => $user->id]) }}" method="POST" style="display: block;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-warning btn-block btn-lg mt-3" value="{{ trans('global.skip') }}">
                </form>
            </div>
            <div class="col-sm-4">
                <form action="{{ route('admin.profile-verifications.approve', ['id' => $user->id]) }}" method="POST" style="display: block;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-success btn-block btn-lg mt-3" value="{{ trans('global.approve') }}">
                </form>
            </div>
        </div><br>

        @if($approvalHistory)
            <a name="talks-table"></a>
            <h4 class="card-title">{{ trans('global.approval_history') }}</h4>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card mb-30">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table m-0 text-center table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                {{ trans('global.date') }}
                                            </th>
                                            <th class="text-center">
                                                {{ trans('global.full_name') }}
                                            </th>
                                            <th class="text-center">
                                                {{ trans('global.state') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($approvalHistory->updated_at)->addMinutes($user->user->timezone) }}</td>
                                            <td>{{ $approvalHistory->name }}</td>
                                            <td>
                                                @if($approvalHistory->status === 1)
                                                    <h6 class="success">Approve</h6>
                                                @elseif($approvalHistory->status === 2)
                                                    <h6 class="danger">Rejected</h6>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
                                            {{ trans('global.talk_name') }}
                                        </th>
                                        <th class="text-center">
                                            {{ trans('cruds.talk.fields.talk_type') }}
                                        </th>
                                        <th class="text-center">
                                            {{ trans('cruds.talk.fields.description') }}
                                        </th>
                                        <th class="text-center">
                                            {{ trans('global.category') }}
                                        </th>
                                        <th class="text-center">
                                            {{ trans('global.subcategory') }}
                                        </th>
                                        <th class="text-center">
                                            {{ trans('cruds.talk.fields.price') }}
                                        </th>
                                        <th class="text-center">
                                            {{ trans('cruds.talk.fields.duration') }}
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
        @if($user->user->count())
            <div class="row">
                <div class="col-md-6">
                    <a name="talks-table"></a>
                    <h4 class="card-title">{{ trans('cruds.availability.title') }}</h4>
                    <div class="card mb-30">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table m-0 text-center table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('global.day') }}</th>
                                            <th>{{ trans('cruds.availability.fields.first_timeslot') }}</th>
                                            <th>{{ trans('cruds.availability.fields.second_timeslot') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->user->userAvailabilities as $userA)

                                            @if($userA->weekday == 1)
                                                <tr>
                                                    <td>{{ trans('global.monday') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->start_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->end_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                </tr>
                                            @endif
                                            @if($userA->weekday == 2)
                                                <tr>
                                                    <td>{{ trans('global.tuesday') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->start_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->end_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                </tr>
                                            @endif
                                            @if($userA->weekday == 3)
                                                <tr>
                                                    <td>{{ trans('global.wednesday') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->start_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->end_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                </tr>
                                            @endif
                                            @if($userA->weekday == 4)
                                                <tr>
                                                    <td>{{ trans('global.thursday') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->start_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->end_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                </tr>
                                            @endif
                                            @if($userA->weekday == 5)
                                                <tr>
                                                    <td>{{ trans('global.friday') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->start_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->end_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                </tr>
                                            @endif
                                            @if($userA->weekday == 6)
                                                <tr>
                                                    <td>{{ trans('global.saturday') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->start_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->end_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                </tr>
                                            @endif
                                            @if($userA->weekday == 7)
                                                <tr>
                                                    <td>{{ trans('global.sunday') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->start_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userA->end_time)->addMinutes($user->user->timezone)->toTimeString() }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <a name="talks-table"></a>
                    <h4 class="card-title">{{ trans('cruds.billingAddress.title') }}</h4>
                    <div class="card mb-30">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table m-0 text-center table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>{{ trans('global.name') }}</td>
                                            <td>{{ $user->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('global.street') }}</td>
                                            <td>
                                                @if($user->user->billingAddress->count())
                                                    {{ $user->user->billingAddress[0]->street }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('global.zip') }}</td>
                                            <td>
                                                @if($user->user->billingAddress->count())
                                                    {{ $user->user->billingAddress[0]->zipcode }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('global.city') }}</td>
                                            <td>
                                                @if($user->user->billingAddress->count())
                                                    {{ $user->user->billingAddress[0]->city }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('global.tax') }}</td>
                                            <td>
                                                @if($user->user->billingAddress->count())
                                                    {{ $user->user->billingAddress[0]->tax_number }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('global.country') }}</td>
                                            <td>
                                                @if($user->user->billingAddress->count())
                                                    @if($user->user->billingAddress[0]->countries->count())
                                                        {{ $user->user->billingAddress[0]->countries->english }}
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('global.vat') }}</td>
                                            <td>
                                                @if($user->user->billingAddress->count())
                                                    {{ $user->user->billingAddress[0]->vat }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-sm-4">
                <form action="{{ route('admin.profile-verifications.disapprove', ['id' => $user->id]) }}" method="POST" style="display: block;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-danger btn-block btn-lg mt-3" value="{{ trans('global.reject') }}">
                </form>
            </div>
            <div class="col-sm-4">
                <form action="{{ route('admin.profile-verifications.skip', ['id' => $user->id]) }}" method="POST" style="display: block;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-warning btn-block btn-lg mt-3" value="{{ trans('global.skip') }}">
                </form>
            </div>
            <div class="col-sm-4">
                <form action="{{ route('admin.profile-verifications.approve', ['id' => $user->id]) }}" method="POST" style="display: block;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-success btn-block btn-lg mt-3" value="{{ trans('global.approve') }}">
                </form>
            </div>
        </div><br>
    @endif
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
                ajax         : "{{ route('admin.user-talks.userTalks', $user->user_id ?? 0) }}",
                columns      : [
                    {
                        name: 'headline',
                        data: function (data, type, row) {
                            return '<a class="link" href="talks/' + data.id + '">' + data.headline + '</a>';
                        }
                    },
                    {
                        data  : 'talk_type',
                        render: function (data) {
                            switch (data) {
                                case {{ TalkTypes::VOICE_CALL }}:
                                    return 'Voice'
                                    break;
                                case {{ TalkTypes::VIDEO_CALL }}:
                                    return 'Video'
                                    break;
                                default:
                                    return ''
                            }
                        }
                    },
                    { data: 'description', name: 'description' },
                    { data: 'talk_categories_english', name: 'talks_categories' },
                    { data: 'talk_subcategories_english', name: 'talks_subcategories' },
                    { data: 'price', name: 'price' },
                    { data: 'duration', name: 'duration' }
                ],
                columnDefs   : [
                    {
                        targets  : 3,
                        className: 'example_matched_left'
                    }
                ],
                orderCellsTop: true,
                order        : [[1, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-Talk').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                                              .columns.adjust();
            });
            $('.datatable-Talk thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value  = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable-Talk thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val    = $.fn.dataTable.util.escapeRegex(
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
