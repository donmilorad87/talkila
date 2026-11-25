@extends('layout.mainlayout')
@section('content')
@can('language_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.languages.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.language.title_singular') }}
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
                    <h5 class="card-title">{{ trans('cruds.language.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover datatable datatable-Language">
                        <thead>
                          <tr>
                              <th>
                                  {{ trans('cruds.language.fields.id') }}
                              </th>
                              <th>
                                  {{ trans('cruds.language.fields.code') }}
                              </th>
                              <th>
                                  {{ trans('cruds.language.fields.english') }}
                              </th>
                              <th>
                                  {{ trans('cruds.language.fields.german') }}
                              </th>
                              <th>
                                  {{ trans('cruds.language.fields.croatian') }}
                              </th>
                              <th>
                                  {{ trans('cruds.language.fields.polish') }}
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
                      <tbody>
                          @foreach($languages as $key => $language)
                              <tr data-entry-id="{{ $language->id }}">
                                  <td>
                                      <a class="link" href="{{ route('admin.languages.edit', $language->id) }}">{{ $language->id ?? '' }}</a>
                                  </td>
                                  <td>
                                      <a class="link" href="{{ route('admin.languages.edit', $language->id) }}">{{ $language->code ?? '' }}</a>
                                  </td>
                                  <td>
                                      <a class="link" href="{{ route('admin.languages.edit', $language->id) }}">{{ $language->english ?? '' }}</a>
                                  </td>
                                  <td>
                                      <a class="link" href="{{ route('admin.languages.edit', $language->id) }}">{{ $language->german ?? '' }}</a>
                                  </td>
                                  <td>
                                      <a class="link" href="{{ route('admin.languages.edit', $language->id) }}">{{ $language->croatian ?? '' }}</a>
                                  </td>
                                  <td>
                                      <a class="link" href="{{ route('admin.languages.edit', $language->id) }}">{{ $language->polish ?? '' }}</a>
                                  </td>
                                  <td>
                                      @can('language_delete')
                                          <form action="{{ route('admin.languages.destroy', $language->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('language_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.languages.massDestroy') }}",
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
  let table = $('.datatable-Language:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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
})

</script>
@endsection