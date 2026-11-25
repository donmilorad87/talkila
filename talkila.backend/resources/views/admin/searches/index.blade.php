@extends('layout.mainlayout')
@section('content')
@can('search_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.searches.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.search.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Search', 'route' => 'admin.searches.parseCsvImport'])
        </div>
    </div>
@endcan
<!-- Data Table -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('cruds.search.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-Search">
                        <thead>
                          <tr>
                              <th width="10">

                              </th>
                              <th>
                                  {{ trans('cruds.search.fields.id') }}
                              </th>
                              <th>
                                  {{ trans('cruds.search.fields.user') }}
                              </th>
                              <th>
                                  {{ trans('cruds.search.fields.term') }}
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
                                  <select class="search">
                                      <option value>{{ trans('global.all') }}</option>
                                      @foreach($users as $key => $item)
                                          <option value="{{ $item }}">{{ $item }}</option>
                                      @endforeach
                                  </select>
                              </td>
                              <td>
                                  <input class="search" type="text" placeholder="{{ trans('global.search') }}">
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
@can('search_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.searches.massDestroy') }}",
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
    ajax: "{{ route('admin.searches.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'user_email', name: 'user.email' },
{ data: 'term', name: 'term' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Search').DataTable(dtOverrideGlobals);
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