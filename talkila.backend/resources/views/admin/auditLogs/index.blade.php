@extends('layout.mainlayout')
@section('content')
<!-- Data Table -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('cruds.auditLog.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-AuditLog">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.auditLog.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.auditLog.fields.description') }}
                                </th>
                                <th>
                                    {{ trans('cruds.auditLog.fields.subject_id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.auditLog.fields.subject_type') }}
                                </th>
                                <th>
                                    {{ trans('cruds.auditLog.fields.user_id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.auditLog.fields.host') }}
                                </th>
                                <th>
                                    {{ trans('cruds.auditLog.fields.created_at') }}
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
    ajax: "{{ route('admin.audit-logs.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'description', name: 'description' },
{ data: 'subject_id', name: 'subject_id' },
{ data: 'subject_type', name: 'subject_type' },
{ data: 'user_id', name: 'user_id' },
{ data: 'host', name: 'host' },
{ data: 'created_at', name: 'created_at' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-AuditLog').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection