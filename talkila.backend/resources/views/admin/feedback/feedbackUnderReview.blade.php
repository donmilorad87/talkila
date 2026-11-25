@extends('layout.mainlayout')
@section('content')
<!-- Stats Card -->
<h5 class="card-title">{{ trans('cruds.feedback.title') }}</h5>

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
                                {{ trans('cruds.user.fields.supplier') }}
                            </th>
                            <th>
                                {{ trans('cruds.user.fields.client') }}
                            </th>
                            <th>
                                {{ trans('cruds.talk.title_singular') }}
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
                                <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <select class="form-control" name="duration" id="duration">
                                    <option value="">- -</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                    <option value="60">60</option>
                                    <option value="75">75</option>
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
            ajax: "{{ route('admin.feedback-under-review') }}",
            "aoColumnDefs": [ {
                "aTargets": [ 5 ],
                "mRender": function ( data, type, full ) {
                    return $("<div/>").html(data).text();
                }
            }],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'talkName', name: 'talkName' },
                { data: 'participantName', name: 'participantName' },
                { data: 'teacherName', name: 'teacherName' },
                { data: 'bookingsCount', name: 'bookingsCount' },
                { data: 'price', name: 'price' },
                { data: 'duration', name: 'duration' },
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
