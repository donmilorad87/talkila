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
                    <table class="table m-0 table-hover datatable datatable-reporterUserUserReporteds">
                        <thead>
                          <tr>
                              <th width="10">

                              </th>
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
                      </thead>
                      <tbody>
                          @foreach($userReporteds as $key => $userReported)
                              <tr data-entry-id="{{ $userReported->id }}">
                                  <td>

                                  </td>
                                  <td>
                                      {{ $userReported->id ?? '' }}
                                  </td>
                                  <td>
                                      {{ $userReported->user->email ?? '' }}
                                  </td>
                                  <td>
                                      {{ $userReported->reporter_user->email ?? '' }}
                                  </td>
                                  <td>
                                      {{ $userReported->description ?? '' }}
                                  </td>
                                  <td>
                                      {{ $userReported->state ?? '' }}
                                  </td>
                                  <td>
                                      @can('user_reported_show')
                                          <a class="btn btn-xs btn-primary" href="{{ route('admin.user-reporteds.show', $userReported->id) }}">
                                              {{ trans('global.view') }}
                                          </a>
                                      @endcan

                                      @can('user_reported_edit')
                                          <a class="btn btn-xs btn-info" href="{{ route('admin.user-reporteds.edit', $userReported->id) }}">
                                              {{ trans('global.edit') }}
                                          </a>
                                      @endcan

                                      @can('user_reported_delete')
                                          <form action="{{ route('admin.user-reporteds.destroy', $userReported->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('user_reported_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.user-reporteds.massDestroy') }}",
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
  let table = $('.datatable-reporterUserUserReporteds:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection