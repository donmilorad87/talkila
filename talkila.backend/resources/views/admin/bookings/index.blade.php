@extends('layout.mainlayout')
@section('content')
    @can('booking_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.bookings.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.booking.title_singular') }}
                </a>
            </div>
        </div>
    @endcan

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5>{{ trans('cruds.booking.title_singular') }} {{ trans('global.list') }}</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 text-center table-bordered table-hover ajaxTable datatable datatable-Booking">
                            <thead>
                                <tr>
                                    {{--                                <th></th>--}}
                                    <th>{{ trans('cruds.booking.fields.id') }}</th>
                                    <th>{{ trans('cruds.booking.fields.supplier') }}</th>
                                    <th>{{ trans('cruds.booking.fields.client') }}</th>
                                    <th>{{ trans('cruds.booking.fields.date') }}</th>
                                    <th>{{ trans('cruds.booking.fields.duration') }}</th>
                                    <th>{{ trans('cruds.booking.fields.price') }}</th>
                                    <th>{{ trans('cruds.booking.fields.payment') }}</th>
                                    <th>{{ trans('cruds.booking.fields.state') }}</th>
                                    <th>&nbsp;</th>
                                </tr>
                                <tr>
                                    <td></td>
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
                                        <select class="form-control" name="type2" id="type2">
                                            <option value>- -</option>
                                            <option value="15">15</option>
                                            <option value="30">30</option>
                                            <option value="45">45</option>
                                            <option value="60">60</option>
                                            <option value="75">75</option>
                                            <option value="90">90</option>
                                            <option value="105">105</option>
                                            <option value="120">120</option>
                                            <option value="135">135</option>
                                            <option value="150">150</option>
                                            <option value="165">165</option>
                                            <option value="180">180</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="form-control" name="type" id="type">
                                            <option value>All</option>
                                            <option value="1">Paid</option>
                                            <option value="7">Cancelled</option>
                                            <option value="11">Cancelled without refund</option>
                                            <option value="12">Cancelled by Teacher</option>
                                            <option value="19">Postponed</option>
                                        </select>
                                    </td>
                                    <td></td>
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
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            @can('booking_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton      = {
                text     : deleteButtonTrans,
                url      : "{{ route('admin.bookings.massDestroy') }}",
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
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.bookings.index') }}",
                columns      : [
                    // { data: 'placeholder', name: 'placeholder' },
                    {
                        name: 'id',
                        data: 'id',
                    },
                    {
                        name: 'supplier',
                        data: function (data) {
                            return '<a class="link" href="{{ route('admin.users.show', ':id') }}'.replace(':id', data.supplier_id) + '">' + data.supplier + '</a>';
                        },
                    },
                    {
                        name: 'client',
                        data: function (data) {
                            return '<a class="link" href="{{ route('admin.users.show', ':id') }}'.replace(':id', data.client_id) + '">' + data.client + '</a>';
                        },
                    },
                    { data: 'start_call', name: 'date' },
                    { data: 'duration', name: 'duration' },
                    { data: 'price', name: 'price' },
                    { data: 'payment', name: 'payment' },
                    {
                        data  : 'state',
                        render: function (data) {
                            switch (data) {
                                case '':
                                    return 'Coming';
                                case 1:
                                    return 'Paid';
                                case 7:
                                    return 'Cancelled';
                                case 11:
                                    return 'Cancelled without refund';
                                case 12:
                                    return 'Cancelled by Teacher';
                                case 19:
                                    return 'Postponed';
                                default:
                                    return '';
                            }
                        },
                    },
                    { data: 'actions', name: '{{ trans('global.actions') }}' },
                ],
                orderCellsTop: true,
                // order: [[ 1, 'asc' ]],
                pageLength: 10,
            };
            let table             = $('.datatable-Booking').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index()).search(value, strict).draw();
            });
            $('.datatable-Booking thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex($(this).val());

                table.column($(this).parent().index()).search(val, strict).draw();
            });
        });
    </script>
@endsection
