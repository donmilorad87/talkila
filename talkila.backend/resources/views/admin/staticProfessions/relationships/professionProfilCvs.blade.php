@can('profil_cv_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.profile-cvs.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.profilCv.title_singular') }}
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
                    <h5 class="card-title">{{ trans('cruds.profilCv.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover datatable datatable-professionProfilCvs">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.profilCv.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.profilCv.fields.user') }}
                                </th>
                                <th>
                                    {{ trans('cruds.profilCv.fields.type') }}
                                </th>
                                <th>
                                    {{ trans('cruds.profilCv.fields.start_date') }}
                                </th>
                                <th>
                                    {{ trans('cruds.profilCv.fields.end_date') }}
                                </th>
                                <th>
                                    {{ trans('cruds.profilCv.fields.company_name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.profilCv.fields.profession') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profilCvs as $key => $profilCv)
                                <tr data-entry-id="{{ $profilCv->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $profilCv->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $profilCv->user->email ?? '' }}
                                    </td>
                                    <td>
                                        {{ $profilCv->type ?? '' }}
                                    </td>
                                    <td>
                                        {{ $profilCv->start_date ?? '' }}
                                    </td>
                                    <td>
                                        {{ $profilCv->end_date ?? '' }}
                                    </td>
                                    <td>
                                        {{ $profilCv->company_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $profilCv->profession->english ?? '' }}
                                    </td>
                                    <td>
                                        @can('profil_cv_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.profile-cvs.show', $profilCv->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('profil_cv_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.profile-cvs.edit', $profilCv->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('profil_cv_delete')
                                            <form action="{{ route('admin.profile-cvs.destroy', $profilCv->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('profil_cv_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.profile-cvs.massDestroy') }}",
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
  let table = $('.datatable-professionProfilCvs:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection