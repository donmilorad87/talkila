@extends('layout.mainlayout')
@section('content')
@can('payout_currency_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.payout-currencies.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.payoutCurrency.title_singular') }}
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
                    <h5 class="card-title">{{ trans('cruds.payoutCurrency.title_singular') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover datatable datatable-FinanceCurrency">
                        <thead>
                            <tr>
                                <th>
                                    {{ trans('cruds.payoutCurrency.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.payoutCurrency.fields.value') }}
                                </th>
                                <th>
                                    {{ trans('cruds.payoutCurrency.fields.symbol') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                  <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($financeCurrencies as $key => $payoutCurrency)
                                <tr data-entry-id="{{ $payoutCurrency->id }}">
                                    <td>
                                        <a class="link" href="{{ route('admin.payout-currencies.edit', $payoutCurrency->id) }}">{{ $payoutCurrency->id ?? '' }}</a>
                                    </td>
                                    <td>
                                        <a class="link" href="{{ route('admin.payout-currencies.edit', $payoutCurrency->id) }}">{{ $payoutCurrency->value ?? '' }}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="link" href="{{ route('admin.payout-currencies.edit', $payoutCurrency->id) }}">{{ $payoutCurrency->symbol ?? '' }}
                                        </a>
                                    </td>
                                    <td>
                                        @can('payout_currency_delete')
                                            <form action="{{ route('admin.payout-currencies.destroy', $payoutCurrency->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('payout_currency_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.payout-currencies.massDestroy') }}",
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
    order: [[ 1, 'asc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-FinanceCurrency:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
