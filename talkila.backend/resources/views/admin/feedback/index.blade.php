@extends('layout.mainlayout')
@section('content')
    <!-- Stats Card -->
    <h5 class="card-title">{{ trans('cruds.feedback.title') }}</h5>
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.staticMetric.fields.reviews') }}</p>
                        <h3 class="mb-0 fs-25">{{ $reviews }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.user.fields.approved') }}</p>
                        <h3 class="mb-0 fs-25">{{ $approved }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.feedback.fields.pending') }}</p>
                        <h3 class="mb-0 fs-25">{{ $pending }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="stats-card-one mb-30">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-10 line-height-1">{{ trans('cruds.feedback.fields.rejected') }}</p>
                        <h3 class="mb-0 fs-25">{{ $rejected }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Stats Card -->
    @if($feedback)
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-30">
                    <div class="card-body">
                        <div class="height-365">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <td>{{ trans('cruds.user.fields.supplier') }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $feedback->calls->teacher_user->id) }}">{{ $feedback->calls->teacher_user->name }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.user.fields.client') }}</td>
                                        <td>
                                            @if($feedback->participiant)
                                            <a href="{{ route('admin.users.show', $feedback->participiant->id) }}">
                                                {{ $feedback->participiant->name }}
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.user.fields.created') }}</td>
                                        <td>{{ $feedback->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.talk.title_singular') }}</td>
                                        <td>
                                            <a href="{{ route('admin.talks.show', $feedback->calls->talk->id) }}">
                                                {{ $feedback->calls->talk->headline }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.feedback.fields.rating') }}</td>
                                        <td>
                                            <div class="Stars" style="--rating: {{ $feedback->stars_content }};"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.feedback.fields.voice') }}</td>
                                        <td>
                                            <div class="Stars" style="--rating: {{ $feedback->stars_voice_quality / 2 }};"></div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-30">
                    <div class="card-body">
                        <div class="height-365" style="padding: 15px">
                            <p>
                                @if($feedback->description != '')
                                    {!! $feedback->description !!}
                                @else
                                    No description
                                @endif
                            </p>
                            <div class="row" style="position:absolute;
bottom:15px; width: 95%">
                                <div class="col-sm-4">
                                    <form action="{{ route('admin.feedback.updateStatus', $feedback->id) }}" method="POST" style="display: block;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="status" value="1">
                                        <input type="submit" class="btn btn-success btn-lg btn-block rounded-0 mt-2 mr-2" value="{{ trans('global.approve') }}">
                                    </form>
                                </div>
                                <div class="col-sm-4">
                                    <form action="{{ route('admin.feedback.updateStatus', $feedback->id) }}" method="POST" style="display: block;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="status" value="3">
                                        <input type="submit" class="btn btn-warning btn-lg btn-block rounded-0 mt-2 mr-2" value="{{ trans('global.skip') }}">
                                    </form>
                                </div>
                                <div class="col-sm-4">
                                    <form action="{{ route('admin.feedback.updateStatus', $feedback->id) }}" method="POST" style="display: block;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="status" value="2">
                                        <input type="submit" class="btn btn-danger btn-lg btn-block rounded-0 mt-2 mr-2" value="{{ trans('global.decline') }}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('cruds.feedback.title_singular') }} {{ trans('global.list') }}</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table m-0 table-bordered table-hover ajaxTable datatable datatable-Feedback">
                            <thead>
                            <tr>
                                <th>
                                    {{ trans('cruds.feedback.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.supplier') }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.client') }}
                                </th>
                                <th>
                                    {{ trans('cruds.talk.title_singular') }}
                                </th>
                                <th>
                                    {{ trans('cruds.feedback.fields.stars_content') }}
                                </th>
                                <th>
                                    {{ trans('cruds.feedback.fields.review') }}
                                </th>
                                <th>
                                    {{ trans('cruds.feedback.fields.state') }}
                                </th>
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
                                    <select class="form-control" name="stars_content" id="stars_content">
                                        <option value="">- -</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <select class="form-control" name="state" id="state">
                                        <option value="">- -</option>
                                        <option value="1">ok</option>
                                        <option value="0">pending</option>
                                        <option value="3">skiped</option>
                                        <option value="2">reject</option>
                                    </select>
                                </td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@if($reviews !== 0)
    <h5 class="card-title">{{ trans('cruds.feedback.analysis') }}</h5>
    <div class="row">
        <div class="col-sm-8">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="height-365">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tbody>
                                <tr>
                                    <td>{{ trans('cruds.feedback.fields.stars') }}</td>
                                    <td>{{ trans('cruds.feedback.fields.total') }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="Stars" style="--rating: 5"></div>
                                    </td>
                                    <td>{{ $stars5 }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="Stars" style="--rating: 4"></div>
                                    </td>
                                    <td>{{ $stars4 }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="Stars" style="--rating: 3"></div>
                                    </td>
                                    <td>{{ $stars3 }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="Stars" style="--rating: 2"></div>
                                    </td>
                                    <td>{{ $stars2 }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="Stars" style="--rating: 1"></div>
                                    </td>
                                    <td>{{ $stars1 }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="height-365">
                        <div id="stars"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
@section('apex-charts')
    <script type="text/javascript">
        (function($) {
            "use strict";
            jQuery(document).on('ready', function() {

                var options = {
                    chart: {
                        width: '100%',
                        height: 391,
                        type: 'pie',
                    },
                    labels: ['5', '4', '3', '2', '1'],
                    colors: ['#007bff', '#6610f2', '#dc3545', '#28a745', '#17a2b8'],
                    series: [<?php print $stars5; ?>, <?php print $stars4; ?>, <?php print $stars3; ?>, <?php print $stars2; ?>, <?php print $stars1; ?>],
                    responsive: [{
                        breakpoint: 300,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }],
                    legend: {
                        horizontalAlign: 'right',
                    }
                }

                var chart = new ApexCharts(
                    document.querySelector("#stars"),
                    options
                );

                chart.render();

            });
        }(jQuery))
    </script>
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtOverrideGlobals = {
                processing: true,
                serverSide: true,
                escape: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.feedback.index') }}",
                "aoColumnDefs": [ {
                    "aTargets": [ 5 ],
                    "mRender": function ( data, type, full ) {
                    return $("<div/>").html(data).text();
                    }
                }],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'calls.teacher_user.name', name: 'calls.teacher_user.name' },
                    { data: 'reviewer.name', name: 'reviewer.name' },
                    {
                       name: 'calls.talk',
                       data: function (data, type, row) {
                        if(data !== null){
                            return '<a class="link" href="../talks/'+data.calls.talk.id+'">'+data.calls.talk.headline+'</a>';
                        }else{
                            return '';
                        }
                    }
                    },
                  //  { data: 'calls.talk.headline', name: 'calls.talk.headline' },
                    { data: 'stars_content', name: 'stars_content' },
                    {
                      name: 'description',
                      data: 'description',
                    },
                    {
                        data: 'state',
                        name: 'state',
                        render: function(data) {
                            switch(data) {
                                case 1:
                                    return '<span style="color: #28a745">ok</span>'
                                    break;
                                case 3:
                                    return '<span style="color: #ffcc00">skiped</span>'
                                    break;
                                case 2:
                                    return '<span style="color: #dc3545">reject</span>'
                                    break;
                                default:
                                    return '<span style="color: #ffcc00">pending</span>'
                            }
                        }
                    },
                ],
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 10,
            };
            let table = $('.datatable-Feedback').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
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
        });
    </script>
@endsection
