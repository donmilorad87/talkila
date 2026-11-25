@extends('layout.mainlayout')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h5>{{ trans('cruds.suggestionsHomeScreen.title_singular') }} {{ trans('global.list') }} ({{ $suggestions_count }})</h5>
            </div>
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-suggestions">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.username') }}
                        </th>
                        <th>
                            {{ trans('cruds.talksCategories.title_singular') }}
                        </th>
                        <th>
                            {{ trans('cruds.userFollowed.fields.follower') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.title') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('cruds.suggestionsHomeScreen.title_add_new_customers') }}</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover ajaxTable datatable datatable-suggestionsHomeScreen">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.username') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.talksCategories.title_singular') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.userFollowed.fields.follower') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.booking.title') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.visibility.title') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.verified') }}
                                    </th>
                                    <th>
                                        &nbsp;
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
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <select class="form-control" name="visibility" id="visibility">
                                            <option value>{{ trans('global.all') }}</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="verified" id="verified">
                                            <option value>{{ trans('global.all') }}</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </thead>
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
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            @can('suggestions_home_screen_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton      = {
                text     : deleteButtonTrans,
                url      : "{{ route('admin.suggestions-home-screen.massDestroy') }}",
                className: 'btn-danger',
                action   : function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                        return entry.id;
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}');

                        return;
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: { 'x-csrf-token': _token },
                            method : 'POST',
                            url    : config.url,
                            data   : { ids: ids, _method: 'DELETE' },
                        })
                         .done(function () { location.reload(); });
                    }
                },
            };
            dtButtons.push(deleteButton);
            @endcan

            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : false,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.suggestions-home-screen.index') }}",
                columns      : [
                    {
                        name: 'username',
                        data: function (data, type, row) {
                            if (data.users !== null) {
                                return '<a class="link" href="users/' + data.user_id + '">' + data.users.username + '</a>';
                            } else {
                                return '';
                            }
                        },
                    },
                    { data: 'talk_category', name: 'talk_category' },
                    { data: 'followers', name: 'followers' },
                    { data: 'bookings', name: 'bookings' },
                    {
                        name: 'actions',
                        data: function (data, type, row) {
                            return data.actions;
                        },
                    },
                ],
                orderCellsTop: true,
                order        : [[1, 'desc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-suggestions').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                                              .columns.adjust();
            });
            $('.datatable-suggestions thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw();
            });
        });

        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            @can('calls_cancellation_reason_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton      = {
                text     : deleteButtonTrans,
                url      : "{{ route('admin.calls-cancellation-reasons.massDestroy') }}",
                className: 'btn btn-danger',
                action   : function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                        return entry.id;
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}');

                        return;
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: { 'x-csrf-token': _token },
                            method : 'POST',
                            url    : config.url,
                            data   : { ids: ids, _method: 'DELETE' },
                        })
                         .done(function () { location.reload(); });
                    }
                },
            };
            dtButtons.push(deleteButton);
            @endcan

            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : false,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.suggestions-home-screen.create') }}",
                columns      : [
                    {
                        name: 'username',
                        data: function (data, type, row) {
                            return '<a class="link" href="users/' + data.id + '">' + data.username + '</a>';
                        },
                    },
                    { data: 'talk_category', name: 'talk_category' },
                    { data: 'followers', name: 'followers' },
                    { data: 'bookings', name: 'bookings' },
                    {
                        data  : 'visibility',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return 'Yes';
                                    break;
                                default:
                                    return 'No';
                            }
                        },
                    },
                    {
                        data  : 'verified',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return 'Yes';
                                    break;
                                default:
                                    return 'No';
                            }
                        },
                    },
                    {
                        name: 'actions',
                        data: function (data, type, row) {
                            switch (data.suggestions_home_screen.length) {
                                case 0:
                                    return data.actions;
                                    break;
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
            let table             = $('.datatable-suggestionsHomeScreen').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                                              .columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw();
            });
            $('.datatable thead select').on('change', function () {
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
