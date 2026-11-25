@can('payout_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.payout-invoices.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.payout.title_singular') }}
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
                    <h5 class="card-title">{{ trans('cruds.payout.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover datatable datatable-financeCurrenciesPayouts">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
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
                        </thead>
                        <tbody>
                            @foreach($payouts as $key => $payout)
                                <tr data-entry-id="{{ $payout->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $payout->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $payout->payout_date ?? '' }}
                                    </td>
                                    <td>
                                        {{ $payout->price ?? '' }}
                                    </td>
                                    <td>
                                        {{ $payout->finance_currencies->symbol ?? '' }}
                                    </td>
                                    <td>
                                        {{ $payout->invoice_number ?? '' }}
                                    </td>
                                    <td>
                                        {{ $payout->sales_tax ?? '' }}
                                    </td>
                                    <td>
                                        {{ $payout->reference ?? '' }}
                                    </td>
                                    <td>
                                        {{ $payout->transferred_date ?? '' }}
                                    </td>
                                    <td>
                                        @can('payout_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.payout-invoices.show', $payout->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('payout_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.payout-invoices.edit', $payout->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('payout_delete')
                                            <form action="{{ route('admin.payout-invoices.destroy', $payout->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
                                        @endcan

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Data Table -->
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('payout_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.payout-invoices.massDestroy') }}",
    className: 'btn btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-financeCurrenciesPayouts:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
