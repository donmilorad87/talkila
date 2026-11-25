@extends('layout.mainlayout')
@section('content')
@can('billing_address_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.billing-addresses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.billingAddress.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'BillingAddress', 'route' => 'admin.billing-addresses.parseCsvImport'])
        </div>
    </div>
@endcan


<!-- Data Table -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('cruds.billingAddress.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-BillingAddress">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.billingAddress.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.billingAddress.fields.street') }}
                                </th>
                                <th>
                                    {{ trans('cruds.billingAddress.fields.zipcode') }}
                                </th>
                                <th>
                                    {{ trans('cruds.billingAddress.fields.city') }}
                                </th>
                                <th>
                                    {{ trans('cruds.billingAddress.fields.company_name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.billingAddress.fields.tax_number') }}
                                </th>
                                <th>
                                    {{ trans('cruds.billingAddress.fields.email') }}
                                </th>
                                <th>
                                    {{ trans('cruds.billingAddress.fields.tel_number') }}
                                </th>
                                <th>
                                    {{ trans('cruds.billingAddress.fields.countries') }}
                                </th>
                                <th>
                                    &nbsp;
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
                                    <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="form-controlsearch" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <select class="form-control search">
                                        <option value>{{ trans('global.all') }}</option>
                                        @foreach($countries as $key => $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
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
@can('billing_address_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.billing-addresses.massDestroy') }}",
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
    ajax: "{{ route('admin.billing-addresses.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'street', name: 'street' },
{ data: 'zipcode', name: 'zipcode' },
{ data: 'city', name: 'city' },
{ data: 'company_name', name: 'company_name' },
{ data: 'tax_number', name: 'tax_number' },
{ data: 'email', name: 'email' },
{ data: 'tel_number', name: 'tel_number' },
{ data: 'countries_name', name: 'countries.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-BillingAddress').DataTable(dtOverrideGlobals);
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
