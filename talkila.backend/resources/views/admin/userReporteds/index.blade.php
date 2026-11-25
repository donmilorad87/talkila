@extends('layout.mainlayout')
@section('content')
@can('user_reported_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.user-reporteds.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.userReported.title_singular') }}
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
                    <h5 class="card-title">{{ trans('cruds.userReported.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-UserReported">
                        <thead>
                          <tr>
                              <th>
                                  {{ trans('cruds.userReported.fields.id') }}
                              </th>
                              <th>
                                  {{ trans('cruds.userReported.fields.user') }}
                              </th>
                              <th>
                                  {{ trans('cruds.userReported.fields.reporter_user') }}
                              </th>
                              <th>
                                  {{ trans('cruds.userReported.fields.description') }}
                              </th>
                              <th>
                                  {{ trans('cruds.userReported.fields.state') }}
                              </th>
                              <th>
                                  &nbsp;
                              </th>
                          </tr>
                          <tr>
                              <td>
                                  <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                              </td>
                              <td>
                                  <select class="form-control search">
                                      <option value>{{ trans('global.all') }}</option>
                                      @foreach($users as $key => $item)
                                          <option value="{{ $item }}">{{ $item }}</option>
                                      @endforeach
                                  </select>
                              </td>
                              <td>
                                  <select class="form-control search">
                                      <option value>{{ trans('global.all') }}</option>
                                      @foreach($users as $key => $item)
                                          <option value="{{ $item }}">{{ $item }}</option>
                                      @endforeach
                                  </select>
                              </td>
                              <td>
                                  <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                              </td>
                              <td>
                                  <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
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
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('user_reported_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.user-reporteds.massDestroy') }}",
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
    ajax: "{{ route('admin.user-reporteds.index') }}",
    columns: [
      {
       data: 'id',
       name: 'id',
       render: function (data, type, row) {
        return '<a class="link" href="user-reporteds/'+row.id+'/edit">'+data+'</a>';
       }
      },
      {
       data: 'user_email',
       data: 'user_email',
       render: function (data, type, row) {
        return '<a class="link" href="user-reporteds/'+row.id+'/edit">'+data+'</a>';
       }
      },
      {
       data: 'reporter_user_email',
       name: 'reporter_user_email',
       render: function (data, type, row) {
        return '<a class="link" href="user-reporteds/'+row.id+'/edit">'+data+'</a>';
       }
      },
      { data: 'description', name: 'description' },
      { data: 'state', name: 'state' },
      { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'asc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-UserReported').DataTable(dtOverrideGlobals);
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
});

</script>
@endsection