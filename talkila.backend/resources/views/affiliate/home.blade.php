@extends('affiliate.layout.main-layout')
@section('content')

    <!-- Main Content Header -->
    <div class="main-content-header">

    </div>

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="headindCardTitle">
                            {{ __("MY_AFFILIATE_EMPLOYEES") }}
                            <a href="{{ route('affiliate.create_employee') }}" class="newEmployeeBtn">
                                {{ __("NEW_EMPLOYEE") }}
                            </a>
                        </h5>
                    </div>
                    @include('affiliate.layout.partials.copy_text')
                    <div class="mt2 mb2">
                        <div id="collapseExample">
                            <h3>
                                <p class="text-center dropdownTitle">{{ __("WELCOME_TO_TALKILA_AFFILIATE_MARKETING") }}</p>

                                <span class="text-right">
                                    <button class="btn btn-primary" type="button" data-opened="0" id="collapseButtonZ">›</button>
                                </span>
                            </h3>
                            <div class="card card-body dropdowGreen">
                                {!! __('AFFILIATE_HOME_DASHBOARD', [
                                                       'imePromenljive' => 500,
                                                       'imePromenljive2' => 50,
                                                       'imePromenljive3' => 1000,
                                                       'imePromenljive4' => 100,
                                                       'imePromenljive5' => 5000,
                                                       'imePromenljive6' => 300,
                                                       'imePromenljive7' => 1250,
                                                       'months' => 12,
                                                   ])!!}

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table m-0 table-hover ajaxTable datatable datatable-Employees">
                            <thead>
                                <tr>
                                    <th>
                                        {{__("NAME")}}
                                    </th>
                                    <th>
                                        {{__("EMAIL")}}
                                    </th>
                                    <th>
                                        # {{ __("REGISTRATIONS") }}
                                    </th>
                                    <th>
                                        # {{ __("REVENUE") }}
                                    </th>
                                    <th>
                                        {{ __("AFFILIATE") }} ID
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
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
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('user_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.users.massDestroy') }}",
                    className: 'btn btn-danger',
                    action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                    return entry.id
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')

                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        headers: {'x-csrf-token': _token},
                        method: 'POST',
                        url: config.url,
                        data: { ids: ids, _method: 'DELETE' }
                    })
                    .done(function () {
                        location.reload()
                    })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('affiliate.home') }}",
                columns: [
                    {
                        data: 'name',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'registration',
                        name: 'created_at'
                    },
                    {
                        data: 'revenue',
                        name: 'created_at'
                    },                    {
                        data: 'affiliate_id',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: '{{ trans('global.actions') }}'
                    }
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 10,
            };
            let table = $('.datatable-Employees').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function() {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
            $('.datatable thead select').on('change', function() {
                let strict = $(this).attr('strict') || false
                var val = $.fn.dataTable.util.escapeRegex(
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
