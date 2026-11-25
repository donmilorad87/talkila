@extends('layout.mainlayout')
@section('content')
@can('country_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.countries.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.country.title_singular') }}
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
                    <h5 class="card-title">{{ trans('cruds.country.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-Country">
                        <thead>
                          <tr>
                            <th>
                                {{ trans('cruds.country.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.country.fields.short_code') }}
                            </th>
                            <th>
                                {{ trans('cruds.country.fields.english') }}
                            </th>
                            <th>
                                {{ trans('cruds.country.fields.german') }}
                            </th>
                            <th>
                                {{ trans('cruds.country.fields.croatian') }}
                            </th>
                            <th>
                                {{ trans('cruds.country.fields.polish') }}
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
@can('country_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.countries.massDestroy') }}",
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
    ajax: "{{ route('admin.countries.index') }}",
    columns: [
{ name: 'id',
  data: function (data, type, row) {
    return '<a class="link" href="countries/'+data.id+'/edit">'+data.id+'</a>';
  }
},
{
  name: 'short_code',
  data: function (data, type, row) {
    return '<a class="link" href="countries/'+data.id+'/edit">'+data.short_code+'</a>';
  },
},
{
  name: 'english',
  data: function (data, type, row) {
    return '<a class="link" href="countries/'+data.id+'/edit">'+data.english+'</a>';
  },
},
{
  name: 'german',
  data: function (data, type, row) {
    return '<a class="link" href="countries/'+data.id+'/edit">'+data.german+'</a>';
  },
},
{
  name: 'croatian',
   data: function (data, type, row) {
    return '<a class="link" href="countries/'+data.id+'/edit">'+data.croatian+'</a>';
  },
},
{
  name: 'polish',
   data: function (data, type, row) {
    return '<a class="link" href="countries/'+data.id+'/edit">'+data.polish+'</a>';
  },
},
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-Country').DataTable(dtOverrideGlobals);
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