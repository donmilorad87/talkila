@can('talk_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.talks.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.talk.title_singular') }}
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
                    <h5 class="card-title">{{ trans('cruds.talk.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover datatable datatable-billingAddressTalks">
                        <thead>
                          <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.talk.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.talk.fields.teacher_user') }}
                            </th>
                            <th>
                                {{ trans('cruds.talk.fields.languages') }}
                            </th>
                            <th>
                                {{ trans('cruds.talk.fields.anonym_call') }}
                            </th>
                            <th>
                                {{ trans('cruds.talk.fields.call_type') }}
                            </th>
                            <th>
                                {{ trans('cruds.talk.fields.talk_type') }}
                            </th>
                            <th>
                                {{ trans('cruds.talk.fields.headline') }}
                            </th>
                            <th>
                                {{ trans('cruds.talk.fields.duration') }}
                            </th>
                            <th>
                                {{ trans('cruds.talk.fields.price') }}
                            </th>
                            <th>
                                {{ trans('cruds.talk.fields.max_participiants') }}
                            </th>
                            <th>
                                {{ trans('cruds.talk.fields.finance_currencies') }}
                            </th>
                            <th>
                                {{ trans('cruds.talk.fields.billing_address') }}
                            </th>
                            <th>
                                {{ trans('cruds.billingAddress.fields.lastname') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                      </thead>
                      <tbody>
                            @foreach($talks as $key => $talk)
                                <tr data-entry-id="{{ $talk->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $talk->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $talk->teacher_user->email ?? '' }}
                                    </td>
                                    <td>
                                        {{ $talk->languages->english ?? '' }}
                                    </td>
                                    <td>
                                        {{ $talk->anonym_call ?? '' }}
                                    </td>
                                    <td>
                                        {{ $talk->call_type ?? '' }}
                                    </td>
                                    <td>
                                        {{ $talk->talk_type ?? '' }}
                                    </td>
                                    <td>
                                        {{ $talk->headline ?? '' }}
                                    </td>
                                    <td>
                                        {{ $talk->duration ?? '' }}
                                    </td>
                                    <td>
                                        {{ $talk->price ?? '' }}
                                    </td>
                                    <td>
                                        {{ $talk->max_participiants ?? '' }}
                                    </td>
                                    <td>
                                        {{ $talk->finance_currencies->symbol ?? '' }}
                                    </td>
                                    <td>
                                        @can('talk_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.talks.show', $talk->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('talk_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.talks.edit', $talk->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('talk_delete')
                                            <form action="{{ route('admin.talks.destroy', $talk->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('talk_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.talks.massDestroy') }}",
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
  let table = $('.datatable-billingAddressTalks:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
