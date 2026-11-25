@extends('layout.mainlayout')
@section('content')
    <style>
        .datatable-payouts tbody td:nth-child(n+2) {
            text-align : right !important;
        }

        .datatable-payouts tfoot th {
            padding    : 8px 10px !important;
            text-align : right !important;
        }

        .datatable-payout-bookings tbody td:nth-child(n+4):nth-child(-n+5) {
            text-align : right !important;
        }

        .cancelled {
            color       : red;
            font-weight : bold;
        }
    </style>
    <!-- Main Content Header -->
    <div class="main-content-header">
        <h1>{{ trans('cruds.payouts.title_singular') . ' - ' . $user->name  }}</h1>
    </div>
    <!-- End Main Content Header -->

    <!-- Stats Card -->
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.payouts.fields.revenue') }}</p>
                        <h3 class="mb-0 fs-25">{{ $user_revenue }}€</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.payouts.fields.commission') }}</p>
                        <h3 class="mb-0 fs-25">{{ $user_commission }}€</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.payouts.fields.payout') }}</p>
                        <h3 class="mb-0 fs-25">{{ $user_payout }}€</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.payouts.fields.transaction') }}</p>
                        <h3 class="mb-0 fs-25">{{ $transaction }}</h3>
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
                        <h5 class="card-title">{{ trans('cruds.payouts.title_singular') }} {{ trans('global.list') }}</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table m-0 table-hover ajaxTable datatable datatable-payouts">
                            <thead>
                                <tr>
                                    {{--                                    <th>--}}
                                    {{--                                    </th>--}}
                                    <th>
                                        {{ trans('cruds.payouts.fields.country_of_residence') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.vat_value') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.bookings_count') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.revenue') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.payout') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.tax') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.net') }}
                                    </th>
                                    {{--                                    <th>&nbsp;</th>--}}
                                </tr>
                                <tr>
                                    {{--                                    <td>--}}
                                    {{--                                    </td>--}}
                                    <td>
                                        <select class="form-control" name="country_of_residence" id="country_of_residence">
                                            <option value>- -</option>
                                            @foreach(collect($user_payouts)->unique('country_of_residence') as $user_payout)
                                                <option value="{{ $user_payout['country_of_residence'] }}">{{ $user_payout['country_of_residence'] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('cruds.payouts.booking_singular') }} {{ trans('global.list') }}</h5>
                    </div>
                    <table class="table m-0 table-hover ajaxTable datatable datatable-payout-bookings">
                        <thead>
                            <tr>
                                <th>
                                </th>
                                <th>
                                    {{ trans('cruds.payouts.fields.date') }}
                                </th>
                                <th>
                                    {{ trans('cruds.payouts.fields.talk') }}
                                </th>
                                <th>
                                    {{ trans('cruds.payouts.fields.price') }}
                                </th>
                                <th>
                                    {{ trans('cruds.payouts.fields.payout') }}
                                </th>
                                <th>
                                    {{ trans('cruds.payouts.fields.country_of_residence') }}
                                </th>
                                <th>
                                    {{ trans('cruds.payouts.fields.cancelled') }}
                                </th>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <select class="form-control" name="country" id="country">
                                        <option value>- -</option>
                                        @foreach($bookings->unique('month') as $booking)
                                            <option value="{{ Carbon\Carbon::parse($booking->month)->format('-m-') }}">{{ $booking->month }}</option>
                                        @endforeach
                                    </select>

                                </td>
                                <td>
                                    <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <select class="form-control" name="country" id="country">
                                        <option value>- -</option>
                                        @foreach($bookings->unique('country') as $booking)
                                            <option value="{{ $booking->country }}">{{ $booking->country }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="cancelled" id="cancelled">
                                        <option value>- -</option>
                                        @foreach($bookings->unique('state') as $booking)
                                            <option value="{{ Str::of($booking->booking_state)->title()->replace('_',' ') }}">{{ Str::of($booking->booking_state)->title()->replace('_',' ') }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </thead>
                    </table>
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
            {{-- let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons); --}}
            {{-- @can('user_delete') --}}
            {{-- let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'; --}}
            {{-- let deleteButton      = { --}}
            {{--     text     : deleteButtonTrans, --}}
            {{--     url      : "{{ route('admin.users.massDestroy') }}", --}}
            {{--     className: 'btn btn-danger', --}}
            {{--     action   : function (e, dt, node, config) { --}}
            {{--         var ids = $.map(dt.rows({ selected: true }).data(), function (entry) { --}}
            {{--             return entry.id; --}}
            {{--         }); --}}

            {{--         if (ids.length === 0) { --}}
            {{--             alert('{{ trans('global.datatables.zero_selected') }}'); --}}

            {{--             return; --}}
            {{--         } --}}

            {{--         if (confirm('{{ trans('global.areYouSure') }}')) { --}}
            {{--             $.ajax({ --}}
            {{--                 headers: { 'x-csrf-token': _token }, --}}
            {{--                 method : 'POST', --}}
            {{--                 url    : config.url, --}}
            {{--                 data   : { ids: ids, _method: 'DELETE' }, --}}
            {{--             }) --}}
            {{--              .done(function () { location.reload(); }); --}}
            {{--         } --}}
            {{--     }, --}}
            {{-- }; --}}
            {{-- dtButtons.push(deleteButton); --}}
            {{-- @endcan --}}

            let dtOverrideGlobals = {
                // buttons      : dtButtons,
                processing    : true,
                serverSide    : true,
                retrieve      : true,
                aaSorting     : [],
                ajax          : "{{ route('admin.payout-invoices.fetch-supplier-payouts', $payout) }}",
                columns       : [
                    {
                        data: 'country_of_residence',
                        name: 'country_of_residence',
                    },
                    {
                        data: 'vat_value',
                        name: 'vat_value',
                    },
                    {
                        data: 'bookings_count',
                        name: 'bookings_count',
                    },
                    {
                        data  : 'revenue',
                        render: function (data) {
                            return parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2 }) + '€';
                        },
                    },
                    {
                        data  : 'payout',
                        render: function (data) {
                            return parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2 }) + '€';
                        },
                    },
                    {
                        data  : 'tax',
                        render: function (data) {
                            return parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2 }) + '€';
                        },
                    },
                    {
                        data  : 'net',
                        render: function (data) {
                            return parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2 }) + '€';
                        },
                    },
                    {{-- { data: 'actions', name: '{{ trans('global.actions') }}' }, --}}
                ],
                orderCellsTop : true,
                order         : [[6, 'desc']],
                pageLength    : 25,
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();

                    api.columns(['3', '4', '5', '6'], {
                        page: 'current',
                    }).every(function () {
                        var sum = this
                            .data()
                            .reduce(function (a, b) {
                                var x = parseFloat(a) || 0;
                                var y = parseFloat(b) || 0;
                                return x + y;
                            }, 0);
                        $(this.footer()).html(sum.toLocaleString('en-US', { minimumFractionDigits: 2 }) + '€');
                    });
                },
            };

            let table = $('.datatable-payouts').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });

            $('.datatable-payouts thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index()).search(value, strict).draw();
            });

            $('.datatable-payouts thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index()).search(val, strict).draw();
            });
        });
    </script>
    <script>
        $(function () {
            let dtOverrideGlobals = {
                // buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.payout-invoices.fetch-supplier-bookings', $payout) }}",
                columns      : [
                    {
                        name: 'DT_RowIndex',
                        data: 'DT_RowIndex',
                    },
                    {
                        data: 'date',
                        name: 'date',
                    },
                    {
                        data  : 'talk',
                        render: function (data, type, row) {
                            return '<a class="link" href="' + '/admin/bookings/' + row.id + '">' + data + '</a>';
                        },
                    },
                    {
                        data  : 'revenue',
                        render: function (data, type, row) {
                            return '<span class="' + (row.cancelled === 'Yes' ? 'cancelled' : '') + '" >' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2 }) + '€</span>';
                        },
                    },
                    {
                        data  : 'payout',
                        render: function (data, type, row) {
                            return '<span class="' + (row.cancelled === 'Yes' ? 'cancelled' : '') + '" >' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2 }) + '€</span>';
                        },
                    },
                    {
                        data: 'country',
                        name: 'country',
                    },
                    {
                        data: 'state',
                        name: 'state',
                    },
                    {{-- { data: 'actions', name: '{{ trans('global.actions') }}' }, --}}
                ],
                orderCellsTop: true,
                order        : [[4, 'desc']],
                pageLength   : 25,
            };

            let table = $('.datatable-payout-bookings').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });

            $('.datatable-payout-bookings thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index()).search(value, strict).draw();
            });

            $('.datatable-payout-bookings thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index()).search($(this).val(), strict).draw();
            });
        });
    </script>
@endsection
