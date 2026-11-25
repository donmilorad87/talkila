@extends('layout.mainlayout')
@section('content')
@can('user_blocked_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.users-blocked.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.userBlocked.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<!-- Data Table -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('cruds.userBlocked.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-UserBlocked">
                        <thead>
                          <tr>
                              <th>
                                  {{ trans('cruds.userBlocked.fields.id') }}
                              </th>
                              <th>
                                  {{ trans('cruds.userBlocked.fields.user') }}
                              </th>
                              <th>
                                  {{ trans('cruds.userBlocked.fields.blocked_user') }}
                              </th>
                              <th>
                                  {{ trans('cruds.userBlocked.fields.state') }}
                              </th>
                              <th>
                                  &nbsp;
                              </th>
                          </tr>
                          <tr>
                            <td>                            
                            </td>
                            <td>                              
                            </td>
                            <td>                            
                            </td>
                            <td>                              
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
@can('user_blocked_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users-blocked.massDestroy') }}",
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
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
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
    ajax: "{{ route('admin.users-blocked.index') }}",
    columns: [
      {
       data: 'id',
       render: function (data, type, row) {
        return '<a class="link" href="users-blocked/'+row.id+'/edit">'+data+'</a>';
       }
      },
      {
       data: 'user_email',
       render: function (data, type, row) {
        return '<a class="link" href="users-blocked/'+row.id+'/edit">'+data+'</a>';
       }
      },
      {
       data: 'blocked_user_email',
       render: function (data, type, row) {
        return '<a class="link" href="users-blocked/'+row.id+'/edit">'+data+'</a>';
       }
      },
      {
        data: 'state',
        render: function(data) {
            switch(data) {
                case 0:
                    return '<span class="danger-color">not valid</span>'
                    break;
                case 1:
                    return '<span class="success-color">valid</span>'
                    break;
                default:
                    return ''
            }
        }
      },
      { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'asc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-UserBlocked').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });  
});

</script>
@endsection