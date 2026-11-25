@extends('affiliate.layout.main-layout')
@section('content')
    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="headindCardTitle"> {{ __("MONTHLY_REPORTS") }}</h5>
                    </div>

                    @include('affiliate.layout.partials.copy_text')

                    <br/>

                    <div class="table-responsive">
                        <table class="table m-0 table-hover ajaxTable datatable datatable-User">
                            <thead>
                            <tr>
                                <th>
                                    {{ __("DATE") }}
                                </th>
                                <th>
                                    {{ __("MONTH") }}
                                </th>
                                <th>
                                    #{{ __("REGISTRATIONS") }}
                                </th>
                                <th>
                                    {{ __("PAYPAL") }}
                                </th>
                                <th>
                                    #{{ __("REVENUE") }}
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
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('affiliate.reports') }}",
                columns: [
                    { data: 'date', name: 'date' },
                    { data: 'month', name: 'month' },
                    { data: 'registrations', name: 'registrations' },
                    { data: 'paypal', name: 'paypal' },
                    { data: 'revenue', name: 'revenue' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' }
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
        });

    </script>
@endsection


