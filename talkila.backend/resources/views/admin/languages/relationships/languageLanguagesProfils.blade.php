@can('languages_profil_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.languages-profils.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.languagesProfil.title_singular') }}
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
                    <h5 class="card-title">{{ trans('cruds.languagesProfil.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-languageLanguagesProfils">
                        <thead>
                          <tr>
                              <th width="10">

                              </th>
                              <th>
                                  {{ trans('cruds.languagesProfil.fields.id') }}
                              </th>
                              <th>
                                  {{ trans('cruds.languagesProfil.fields.user') }}
                              </th>
                              <th>
                                  {{ trans('cruds.languagesProfil.fields.language') }}
                              </th>
                              <th>
                                  {{ trans('cruds.languagesProfil.fields.level') }}
                              </th>
                              <th>
                                  &nbsp;
                              </th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($languagesProfils as $key => $languagesProfil)
                              <tr data-entry-id="{{ $languagesProfil->id }}">
                                  <td>

                                  </td>
                                  <td>
                                      {{ $languagesProfil->id ?? '' }}
                                  </td>
                                  <td>
                                      {{ $languagesProfil->user->name ?? '' }}
                                  </td>
                                  <td>
                                      {{ $languagesProfil->language->code ?? '' }}
                                  </td>
                                  <td>
                                      {{ $languagesProfil->level ?? '' }}
                                  </td>
                                  <td>
                                      @can('languages_profil_show')
                                          <a class="btn btn-xs btn-primary" href="{{ route('admin.languages-profils.show', $languagesProfil->id) }}">
                                              {{ trans('global.view') }}
                                          </a>
                                      @endcan

                                      @can('languages_profil_edit')
                                          <a class="btn btn-xs btn-info" href="{{ route('admin.languages-profils.edit', $languagesProfil->id) }}">
                                              {{ trans('global.edit') }}
                                          </a>
                                      @endcan

                                      @can('languages_profil_delete')
                                          <form action="{{ route('admin.languages-profils.destroy', $languagesProfil->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('languages_profil_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.languages-profils.massDestroy') }}",
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
  let table = $('.datatable-languageLanguagesProfils:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection