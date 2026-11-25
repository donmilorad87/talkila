@can('feedback_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.feedback.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.feedback.title_singular') }}
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
                    <h5 class="card-title">{{ trans('cruds.feedback.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover datatable datatable-participiantFeedback">
                        <thead>
                          <tr>
                              <th width="10">

                              </th>
                              <th>
                                  {{ trans('cruds.feedback.fields.id') }}
                              </th>
                              <th>
                                  {{ trans('cruds.feedback.fields.participiant') }}
                              </th>
                              <th>
                                  {{ trans('cruds.feedback.fields.calls') }}
                              </th>
                              <th>
                                  {{ trans('cruds.feedback.fields.stars_content') }}
                              </th>
                              <th>
                                  {{ trans('cruds.feedback.fields.stars_voice_quality') }}
                              </th>
                              <th>
                                  &nbsp;
                              </th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($feedback as $key => $feedback)
                              <tr data-entry-id="{{ $feedback->id }}">
                                  <td>

                                  </td>
                                  <td>
                                      {{ $feedback->id ?? '' }}
                                  </td>
                                  <td>
                                      {{ $feedback->participiant->email ?? '' }}
                                  </td>
                                  <td>
                                      {{ $feedback->calls->message ?? '' }}
                                  </td>
                                  <td>
                                      {{ $feedback->stars_content ?? '' }}
                                  </td>
                                  <td>
                                      {{ $feedback->stars_voice_quality ?? '' }}
                                  </td>
                                  <td>
                                      @can('feedback_show')
                                          <a class="btn btn-xs btn-primary" href="{{ route('admin.feedback.show', $feedback->id) }}">
                                              {{ trans('global.view') }}
                                          </a>
                                      @endcan

                                      @can('feedback_edit')
                                          <a class="btn btn-xs btn-info" href="{{ route('admin.feedback.edit', $feedback->id) }}">
                                              {{ trans('global.edit') }}
                                          </a>
                                      @endcan

                                      @can('feedback_delete')
                                          <form action="{{ route('admin.feedback.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                              <input type="hidden" name="_method" value="DELETE">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                              <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                          </form>
                                      @endcan

                                  </td>

                              </tr>
                          @endforeach
                      </tbody
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
@can('feedback_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.feedback.massDestroy') }}",
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
  let table = $('.datatable-participiantFeedback:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection