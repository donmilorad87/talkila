@extends('layout.mainlayout')
@section('content')
    <!-- Stats Card -->
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">Affiliate users total</p>
                        <h3 class="mb-0 fs-25">{{ number_format($totalAffiliateUsers, 0) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">Approved</p>
                        <h3 class="mb-0 fs-25">{{ $totalApproved }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">Disapproved</p>
                        <h3 class="mb-0 fs-25">{{ $totalDisapproved }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">Total revenue</p>
                        <h3 class="mb-0 fs-25"> {{ $totalRevenue }}</h3>
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
                                <th>

                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.email') }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.state.title') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                            <tr>
                                <td>

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
                                <td>
                                    <select class="form-control" name="approved" id="approved">
                                        <option value="">all</option>
                                        <option value="0">not approved</option>
                                        <option value="1">approved</option>
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
    <!-- End Data Table -->
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            let dtOverrideGlobals = {
                    buttons: dtButtons,
                    processing: true,
                    serverSide: true,
                    retrieve: true,
                    aaSorting: [],
                    ajax: "{{ route('admin.users.affiliateUsers') }}",
                    columns: [
                        { data: 'placeholder', name: 'placeholder' },
                        { name: 'id',
                            data: function (data, type, row) {
                                return '<a class="link" href="users/'+data.id+'/edit">'+data.id+'</a>';
                            }
                        },
                        { name: 'name',
                            data: function (data, type, row) {
                                return '<a class="link" href="users/'+data.id+'/edit">'+data.name+'</a>';
                            }
                        },
                        { data: 'email', name: 'email' },
                        {
                            data: 'approved',
                            render: function(data) {
                                switch(data) {
                                    case 0:
                                        return '<span class="danger-color">not&nbsp;approved</span>'
                                        break;
                                    case 1:
                                        return '<span class="success-color">approved</span>'
                                        break;
                                    default:
                                        return ''
                                }
                            }
                        },
                        { data: 'actions', name: '{{ trans('global.actions') }}' }
                    ],
                    aoColumnDefs: [
                        { "bSortable": false, "aTargets": [ 0, 1,2, 3 ] },
                    ],
                    orderCellsTop: true,
                    order: [[ 1, 'desc' ]],
                    pageLength: 10,
                };
            let table = $('.datatable-User').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable thead select').on('change', function () {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw()
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
        });

    </script>
@endsection
