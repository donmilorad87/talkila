@extends('layout.mainlayout')
@section('content')
    <style>
        tbody td {
            vertical-align : middle !important;
        }

        tbody td:nth-child(n+2) {
            text-align : right !important;
        }
    </style>

    <!-- Main Content Header -->
    <div class="main-content-header">
        <h1>{{ trans('cruds.payouts.title') }}</h1>
    </div>
    <!-- End Main Content Header -->

    <!-- Stats Card -->
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.payouts.fields.revenue') }}</p>
                        <h3 class="mb-0 fs-25">{{ $revenue }}€</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.payouts.fields.commission') }}</p>
                        <h3 class="mb-0 fs-25">{{ $commission }}€</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.payouts.fields.payout') }}</p>
                        <h3 class="mb-0 fs-25">{{ $payout }}€</h3>
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
                        <h5 class="card-title">{{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table m-0 table-hover ajaxTable datatable datatable-payouts">
                            <thead>
                                <tr>
                                    <th>
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.invoice_number') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.reference') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.revenue') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.commission') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.bookings') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.paid_bookings') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.payouts.fields.cancelled_bookings') }}
                                    </th>
                                    <th>&nbsp;</th>
                                </tr>
                                <tr>
                                    <td>
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
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td></td>
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
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.payout-invoices.fetch-monthly-payouts') }}",
                columns      : [
                    {
                        name: 'DT_RowIndex',
                        data: 'DT_RowIndex',
                    },
                    {
                        data: 'invoice_number',
                        name: 'invoice_number',
                    },
                    {
                        data: 'reference',
                        name: 'reference',
                    },
                    {
                        data  : 'revenue',
                        render: function (data) {
                            return parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2 }) + '€';
                        },
                    },
                    {
                        data  : 'commission',
                        render: function (data) {
                            return parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2 }) + '€';
                        },
                    },
                    {
                        data: 'bookings',
                        name: 'bookings',
                    },
                    {
                        data: 'paid_bookings',
                        name: 'paid_bookings',
                    },
                    {
                        data: 'cancelled_bookings',
                        name: 'cancelled_bookings',
                    },
                    { data: 'actions', name: '{{ trans('global.actions') }}' },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 100,
            };

            let table = $('.datatable-payouts').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });

            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index()).search(value, strict).draw();
            });

            $('.datatable thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index()).search(val, strict).draw();
            });
        });
    </script>
@endsection
