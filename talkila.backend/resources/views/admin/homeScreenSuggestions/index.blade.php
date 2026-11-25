@extends('layout.mainlayout')
@section('content')

<!-- Data Table -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-User">
                        <thead>
                          <tr>
                              <th>
                                  {{ trans('cruds.user.fields.username') }}
                              </th>
                              <th>
                                  {{ trans('cruds.user.fields.profession') }}
                              </th>
                             <th>
                                  {{ trans('cruds.user.fields.follower') }}
                              </th>
                              <th>
                                  {{ trans('cruds.user.fields.bookings') }}
                              </th>
                              <th>
                                  {{ trans('cruds.user.fields._visibility') }}
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

<!-- Data Table -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-User">
                        <thead>
                          <tr>
                              <th>
                                  {{ trans('cruds.user.fields.username') }}
                              </th>
                              <th>
                                  {{ trans('cruds.user.fields.profession') }}
                              </th>
                             <th>
                                  {{ trans('cruds.user.fields.follower') }}
                              </th>
                              <th>
                                  {{ trans('cruds.user.fields.bookings') }}
                              </th>
                              <th>
                                  {{ trans('cruds.user.fields.visibility') }}
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
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
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
    ajax: "{{ route('admin.users.index') }}",
    columns: [
      { data: 'username', name: 'username' },
      { data: 'profession', name: 'profession' },
      { data: 'followed', name: 'followed' },
      { data: 'bookings', name: 'bookings' },
      { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-User').DataTable(dtOverrideGlobals);
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
