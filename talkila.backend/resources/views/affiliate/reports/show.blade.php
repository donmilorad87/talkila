@extends('affiliate.layout.main-layout')
@section('content')
    <!-- Data Table -->
    <div class="row reportsHome">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="cardTitleZ">{{__('MONTH_YEAR_REVENUE',
                            [
                                'month' => 'June',
                                'year' => 2022,
                                'number' => '27.750'
                            ]
                        )}}</h5>
                    </div>

                    <!-- End Main Content Header -->
                    @include('affiliate.layout.partials.copy_text')

                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam accumsan est at dolor iaculis
                        porttitor. </p>

                    <div class="df aic jcc cardsContainer">
                        <div class="text-center borderZ df aic jcc f1">
                            {!! __('REPORT_BLOCK_1', [
                                                       'imePromenljive' => 500,
                                                       'imePromenljive2' => 50,
                                                       'imePromenljive3' => floatval(500 * 50)
                                                   ])!!}
                        </div>
                        <div class="text-center borderZ df aic jcc f1">
                            {!! __('REPORT_BLOCK_2', [
                                                       'imePromenljive4' => 500,
                                                       'imePromenljive5' => 1000,
                                                       'imePromenljive6' => floatval(500 * 1000)
                                                   ])!!}
                        </div>
                        <div class="text-center borderZ df aic jcc f1">
                            {!! __('REPORT_BLOCK_3', [
                                                       'imePromenljive7' => 100,
                                                       'imePromenljive8' => 5000,
                                                       'imePromenljive9' => floatval(100 * 5000)
                                                   ])!!}
                        </div>
                    </div>

                    <h3 class="mt2 mb2">4.302 {{ __("REGISTRATIONS_IN") }} June 2022</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam accumsan est at dolor iaculis
                        porttitor.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam accumsan est at dolor iaculis
                        porttitor.
                        Praesent sed tempor metus. In ac urna tempor, ornare lectus eu, porta risus. Morbi vel felis nisl.
                        Sed cursus tortor nec erat auctor mollis.
                        Donec nec tincidunt urna. Quisque vestibulum vulputate tortor at lacinia. Suspendisse placerat
                        scelerisque ligula vitae iaculis.
                        Nam euismod dignissim vestibulum.</p>

                    <!-- Mixed Charts Line Column -->
                    <div id="chart"></div>

                    <table class="table tbl mt2 mb2 table-hover datatable datatable-NewRegistrations">
                        <thead>
                            <tr>
                                <th>{{ __("DATE") }}</th>
                                <th>#{{ __("NEW_REGISTRATIONS") }}</th>
                            </tr>


                        </thead>
                        <tbody>
                            @foreach($registrations as $registration)
                                <tr>
                                    <td>{{ $registration['date'] }}</td>
                                    <td>{{ $registration['registrations'] }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <h3 class="mt2 mb2">27.750$ {{ __("REVENUE") }} June 2022</h3>

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

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('affiliate.reports.show', $requestedId) }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'stage_1',
                        name: 'stage_1'
                    },
                    {
                        data: 'stage_2',
                        name: 'stage_2'
                    },
                    {
                        data: 'stage_3',
                        name: 'stage_3'
                    },
                    {
                        data: 'revenue',
                        name: 'revenue'
                    }
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 10,
            };
            let table = $('.datatable-User').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            var data = JSON.parse('{{ json_encode($registrationData) }}');
            var categories = JSON.parse('{{ json_encode($registrationCategories) }}');
            var max_registrations = Math.max.apply(Math,data) + 5;

            var options = {
                series: [{
                    name: "Registrations",
                    data: data
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                grid: {

                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: categories
                },
                yaxis: {
                    max: max_registrations
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>
@endsection
