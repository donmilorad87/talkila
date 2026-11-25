@extends('layout.mainlayout')
@section('content')
    @can('page_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.cms.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.page.title_singular') }}
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
                        <h5 class="card-title">{{ trans('cruds.page.title_singular') }} {{ trans('global.list') }}</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table m-0 table-hover ajaxTable datatable datatable-Talk">
                            <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.page.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.page.fields.title') }}
                                </th>
                                <th>
                                    {{ trans('cruds.page.fields.slug') }}
                                </th>
                                <th>
                                    {{ trans('cruds.page.fields.language') }}
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
                                    <select class="form-control" name="language" id="language">
                                        <option value>- -</option>
                                        <option value="en">English</option>
                                        <option value="hr">Croatian</option>
                                        <option value="de">German</option>
                                        <option value="pl">Polish</option>
                                    </select>
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
                    @can('page_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.cms.massDestroy') }}",
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
                    aaSorting: ['id'],
                    ajax: "{{ route('admin.cms.index') }}",
                    columns: [
                        { data: 'placeholder', name: 'placeholder' },
                        { data: 'id', name: 'id' },
                        {
                          name: 'title',
                          data: function (data, type, row) {
                            return '<a class="link" href="cms/'+data.id+'">'+data.title+'</a>';
                          },
                        },
                        { data: 'slug', name: 'slug' },
                        { data: 'language', name: 'language' },
                        { data: 'actions', name: '{{ trans('global.actions') }}' }
                    ],
                    orderCellsTop: true,
                    order: [[ 1, 'desc' ]],
                    pageLength: 100,
                };
            let table = $('.datatable-Talk').DataTable(dtOverrideGlobals);
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

            $('.datatable-Talk thead select').on('change', function () {
              let strict = $(this).attr('strict') || false
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );

              table
                .column($(this).parent().index())
                .search(val, strict)
                .draw()
            });
        });

    </script>
@endsection
