@can('booking_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.bookings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.booking.title_singular') }}
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
                    <h5 class="card-title">{{ trans('cruds.booking.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-Permission">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.booking.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.booking.fields.state') }}
                                </th>
                                <th>
                                    {{ trans('cruds.booking.fields.extension') }}
                                </th>
                                <th>
                                    {{ trans('cruds.booking.fields.anonym') }}
                                </th>
                                <th>
                                    {{ trans('cruds.booking.fields.participant_user') }}
                                </th>
                                <th>
                                    {{ trans('cruds.booking.fields.start_call') }}
                                </th>
                                <th>
                                    {{ trans('cruds.booking.fields.end_call') }}
                                </th>
                                <th>
                                    {{ trans('cruds.booking.fields.duration') }}
                                </th>
                                <th>
                                    {{ trans('cruds.booking.fields.price') }}
                                </th>
                                <th>
                                    {{ trans('cruds.booking.fields.finance_currencies') }}
                                </th>
                                <th>
                                    {{ trans('cruds.booking.fields.message') }}
                                </th>
                                <th>
                                    {{ trans('cruds.booking.fields.cancellation_reason') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $key => $booking)
                                <tr data-entry-id="{{ $booking->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $booking->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $booking->state ?? '' }}
                                    </td>
                                    <td>
                                        {{ $booking->booking_type ?? '' }}
                                    </td>
                                    <td>
                                        {{ $booking->anonym ?? '' }}
                                    </td>
                                    <td>
                                        {{ $booking->participant_user->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $booking->start_call ?? '' }}
                                    </td>
                                    <td>
                                        {{ $booking->end_call ?? '' }}
                                    </td>
                                    <td>
                                        {{ $booking->duration ?? '' }}
                                    </td>
                                    <td>
                                        {{ $booking->price ?? '' }}
                                    </td>
                                    <td>
                                        {{ $booking->finance_currencies->symbol ?? '' }}
                                    </td>
                                    <td>
                                        {{ $booking->message ?? '' }}
                                    </td>
                                    <td>
                                        {{ $booking->cancellation_reason->english ?? '' }}
                                    </td>
                                    <td>
                                        @can('booking_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.bookings.show', $booking->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('booking_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('booking_delete')
                                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('booking_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bookings.massDestroy') }}",
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
  let table = $('.datatable-cancellationReasonBookings:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
