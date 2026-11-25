@extends('layout.mainlayout')
@section('content')
    <!-- Main Content Header -->
    <div class="main-content-header">
        <h1>{{ trans('cruds.user.fields.all_users') }}</h1>
    </div>
    <!-- End Main Content Header -->

    <!-- Stats Card -->
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.user.fields.active_users') }}</p>
                        <h3 class="mb-0 fs-25">{{ $users->active }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.user.fields.verified') }}</p>
                        <h3 class="mb-0 fs-25">{{ $users->verified }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.user.fields.clients') }}</p>
                        <h3 class="mb-0 fs-25">{{ $nTotalCustomersThisMonth}}</h3>
                    </div>

                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.user.fields.supplier') }}</p>
                        <h3 class="mb-0 fs-25">{{ $users->supplier }}</h3>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.user.fields.private') }}</p>
                        <h3 class="mb-0 fs-25">{{ $users->private }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Stats Card -->

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table m-0 table-hover ajaxTable datatable datatable-User">
                            <thead>
                                <tr>
                                    {{--                                    <th width="10">--}}
                                    {{--                                    </th>--}}
                                    <th>
                                        {{ trans('cruds.user.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.username') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.type') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.state.title') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields._visibility') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.verified') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.email') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.created') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                                <tr>
                                    {{--                                    <td>--}}
                                    {{--                                    </td>--}}
                                    <td>
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="form-control" name="type" id="type">
                                            <option value="">- -</option>
                                            <option value="1">User</option>
                                            <option value="2">Supplier</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="state" id="state">
                                            <option value="">- -</option>
                                            <option value="1">Active</option>
                                            <option value="2">Yes</option>
                                            <option value="3">No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="visibility" id="visibility">
                                            <option value="">- -</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="verified" id="verified">
                                            <option value="">- -</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
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
    <!-- End Data Table -->
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            @can('user_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton      = {
                text     : deleteButtonTrans,
                url      : "{{ route('admin.users.massDestroy') }}",
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
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.users.index') }}",
                columns      : [
                    // { data: 'placeholder', name: 'placeholder' },
                    {
                        data  : 'id',
                        render: function (data) {
                            return '<a href="' + '/users/' + data + '">' + data + '</a>';
                        },
                    },
                    {
                        data  : 'username',
                        render: function (data, type, row) {
                            if (! data) {
                                return '<a href="' + '/users/' + row.id + '">No Username</a>';
                            }

                            return '<a href="' + '/users/' + row.id + '">' + data + '</a>';
                        },
                    },
                    {
                        data  : 'type',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return 'User';
                                    break;
                                case 2:
                                    return 'Supplier';
                                    break;
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
                                    return 'Active';
                                    break;
                                case 2:
                                    return 'Yes';
                                    break;
                                case 3:
                                    return 'No';
                                    break;
                                default:
                                    return '';
                            }
                        },
                    },
                    {
                        data  : 'visibility',
                        render: function (data) {
                            switch (data) {
                                case 1:
                                    return 'Yes';
                                    break;
                                case 0:
                                    return 'No';
                                    break;
                                default:
                                    return '';
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
                                case 0 || '':
                                    return 'No';
                                    break;
                                default:
                                    return '';
                            }
                        },
                    },
                    { data: 'email', name: 'email' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-User').DataTable(dtOverrideGlobals);
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

