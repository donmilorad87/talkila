@extends('layout.mainlayout')
@section('content')
<!-- Data Table -->
<div class="card">
    <div class="card-body">
        <div class="card-header">
            <h5>{{ trans('cruds.payout.title_singular') }} {{ trans('global.list') }}</h5>
        </div>
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Payout">
            <thead>
            <tr>
                <th>
                    {{ trans('cruds.payout.fields.id') }}
                </th>
                <th>
                    {{ trans('cruds.payout.fields.payout_date') }}
                </th>
                <th>
                    {{ trans('cruds.payout.fields.price') }}
                </th>
                <th>
                    {{ trans('cruds.payout.fields.finance_currencies') }}
                </th>
                <th>
                    {{ trans('cruds.payout.fields.invoice_number') }}
                </th>
                <th>
                    {{ trans('cruds.payout.fields.sales_tax') }}
                </th>
                <th>
                    {{ trans('cruds.payout.fields.reference') }}
                </th>
                <th>
                    {{ trans('cruds.payout.fields.transferred_date') }}
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
                </td>
                <td>
                    <input class="form-control  search" type="text" placeholder="{{ trans('global.search') }}">
                </td>
                <td>
                    <select class="form-control  search">
                        <option value>{{ trans('global.all') }}</option>
                        @foreach($finance_currencies as $key => $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input class="form-control  search" type="text" placeholder="{{ trans('global.search') }}">
                </td>
                <td>
                    <input class="form-control  search" type="text" placeholder="{{ trans('global.search') }}">
                </td>
                <td>
                    <input class="form-control  search" type="text" placeholder="{{ trans('global.search') }}">
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
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('payout_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.payout-invoices.massDestroy') }}",
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
    ajax: "{{ route('admin.payout-invoices.index') }}",
    columns: [
      {
         data: 'id',
         render: function (data, type, row) {
          return '<a class="link" href="payout-invoices/'+row.id+'/edit">'+data+'</a>';
         }
      },
      {
         data: 'payout_date',
         render: function (data, type, row) {
          return '<a class="link" href="payout-invoices/'+row.id+'/edit">'+data+'</a>';
         }
      },
      {
         data: 'price',
         render: function (data, type, row) {
          return '<a class="link" href="payout-invoices/'+row.id+'/edit">'+data+'</a>';
         }
      },
      { data: 'finance_currencies_symbol', name: 'finance_currencies.symbol' },
      {
         data: 'invoice_number',
         render: function (data, type, row) {
          return '<a class="link" href="payout-invoices/'+row.id+'/edit">'+data+'</a>';
         }
      },
      {
         data: 'sales_tax',
         render: function (data, type, row) {
          return '<a class="link" href="payout-invoices/'+row.id+'/edit">'+data+'</a>';
         }
      },
      {
         data: 'reference',
         render: function (data, type, row) {
          return '<a class="link" href="payout-invoices/'+row.id+'/edit">'+data+'</a>';
         }
      },
      {
         data: 'transferred_date',
         render: function (data, type, row) {
          return '<a class="link" href="payout-invoices/'+row.id+'/edit">'+data+'</a>';
         }
      },
      { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Payout').DataTable(dtOverrideGlobals);
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
