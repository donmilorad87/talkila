@extends('layout.mainlayout')
@section('content')
@can('calls_cancellation_reason_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.calls-cancellation-reasons.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.callsCancellationReason.title_singular') }}
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
                    <h5 class="card-title">{{ trans('cruds.callsCancellationReason.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-CallsCancellationReason">
                      <thead>
                        <tr>
                            <th>
                                {{ trans('cruds.callsCancellationReason.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.callsCancellationReason.fields.croatian') }}
                            </th>
                            <th>
                                {{ trans('cruds.callsCancellationReason.fields.german') }}
                            </th>
                            <th>
                                {{ trans('cruds.callsCancellationReason.fields.english') }}
                            </th>
                            <th>
                                {{ trans('cruds.callsCancellationReason.fields.polish') }}
                            </th>
                            <th>
                                {{ trans('cruds.callsCancellationReason.fields.state') }}
                            </th>
                            <th>
                                {{ trans('cruds.callsCancellationReason.fields.type') }}
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
                                <select class="form-control" name="state" id="state">
                                    <option value>All</option>
                                    <option value="1">approved</option>
                                    <option value="0">not approved</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="type" id="type">
                                    <option value="">All</option>
                                    <option value="1">Client</option>
                                    <option value="3">Active talk client</option>
                                    <option value="2">Supplier</option>
                                    <option value="4">Active talk supplier</option>
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
@can('calls_cancellation_reason_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.calls-cancellation-reasons.massDestroy') }}",
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
    ajax: "{{ route('admin.calls-cancellation-reasons.index') }}",
    columns: [
      {
         name: 'id',
         data: 'id',
         render: function (data, type, row) {
          return '<a class="link" href="calls-cancellation-reasons/'+row.id+'/edit">'+data+'</a>';
         }
      },
      {
         name: 'croatian',
         data: 'croatian',
         render: function (data, type, row) {
          return '<a class="link" href="calls-cancellation-reasons/'+row.id+'/edit">'+data+'</a>';
         }
      },
      {
         name: 'german',
         data: 'german',
         render: function (data, type, row) {
          return '<a class="link" href="calls-cancellation-reasons/'+row.id+'/edit">'+data+'</a>';
         }
      },
      {
         name: 'english',
         data: 'english',
         render: function (data, type, row) {
          return '<a class="link" href="calls-cancellation-reasons/'+row.id+'/edit">'+data+'</a>';
         }
      },
      {
         name: 'polish',
         data: 'polish',
         render: function (data, type, row) {
          return '<a class="link" href="calls-cancellation-reasons/'+row.id+'/edit">'+data+'</a>';
         }
      },
      {
      data: 'state',
      render: function(data) {
        switch(data) {
          case 1:
            return '<span class="success-color">approved</span>'
            break;
          default:
            return '<span class="danger-color">not approved</span>'
        }
      },
    },
      {
      data: 'type',
      render: function(data) {
        switch(data) {
          case 1:
            return '<span>client</span>'
            break;
          case 2:
            return '<span>supplier</span>'
            break;
          case 3:
            return '<span>active talk client</span>'
            break;
          case 4:
            return '<span>active talk supplier</span>'
            break;
          default:
            return ''
        }


      },
    },
      { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'asc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-CallsCancellationReason').DataTable(dtOverrideGlobals);
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
