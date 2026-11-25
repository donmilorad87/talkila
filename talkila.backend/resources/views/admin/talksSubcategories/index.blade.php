@extends('layout.mainlayout')
@section('content')
    @can('talk_subcategories_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.talk-subcategories.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.talksSubcategories.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h5>{{ trans('cruds.talksSubcategories.title_singular') }} {{ trans('global.list') }}</h5>
            </div>
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Cms">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.talksSubcategories.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.talksCategories.title') }}
                        </th>
                        <th>
                            {{ trans('global.used') }}
                        </th>
                        <th>
                            {{ trans('cruds.talksSubcategories.fields.german') }}
                        </th>
                        <th>
                            {{ trans('cruds.talksSubcategories.fields.english') }}
                        </th>
                        <th>
                            {{ trans('cruds.talksSubcategories.fields.croatian') }}
                        </th>
                        <th>
                            {{ trans('cruds.talksSubcategories.fields.polish') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <select class="form-control" name="category" id="category">
                                <option value>{{ trans('global.all') }}</option>
                                @if($categories)
                                    @foreach($categories as $c)
                                        <option value="{{ $c->english }}">{{ $c->english }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </td>
                        <td>
                        </td>
                        <td>
                            <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            @can('talk_subcategories_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton      = {
                text     : deleteButtonTrans,
                url      : "{{ route('admin.talk-subcategories.massDestroy') }}",
                className: 'btn-danger',
                action   : function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                        return entry.id;
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}');

                        return;
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: { 'x-csrf-token': _token },
                            method : 'POST',
                            url    : config.url,
                            data   : { ids: ids, _method: 'DELETE' },
                        })
                         .done(function () { location.reload(); });
                    }
                },
            };
            dtButtons.push(deleteButton);
            @endcan

            let dtOverrideGlobals = {
                buttons      : dtButtons,
                processing   : true,
                serverSide   : true,
                retrieve     : true,
                aaSorting    : [],
                ajax         : "{{ route('admin.talk-subcategories.index') }}",
                columns      : [
                    {
                        data  : 'id',
                        render: function (data, type, row) {
                            return '<a class="link" href="talk-subcategories/' + row.id + '/edit">' + data + '</a>';
                        },
                    },
                    { data: 'category', name: 'category' },
                    { data: 'talks', name: 'talks' },
                    {
                        data  : 'german',
                        render: function (data, type, row) {
                            return '<a class="link" href="talk-subcategories/' + row.id + '/edit">' + data + '</a>';
                        },
                    },
                    {
                        data  : 'english',
                        render: function (data, type, row) {
                            return '<a class="link" href="talk-subcategories/' + row.id + '/edit">' + data + '</a>';
                        },
                    },
                    {
                        data  : 'croatian',
                        render: function (data, type, row) {
                            return '<a class="link" href="talk-subcategories/' + row.id + '/edit">' + data + '</a>';
                        },
                    },
                    {
                        data  : 'polish',
                        render: function (data, type, row) {
                            return '<a class="link" href="talk-subcategories/' + row.id + '/edit">' + data + '</a>';
                        },
                    },
                    { data: 'actions', name: '{{ trans('global.actions') }}' },
                ],
                orderCellsTop: true,
                order        : [[0, 'asc']],
                pageLength   : 10,
                columnDefs   : [
                    { orderable: false, targets: 2 },
                ],
            };
            let table             = $('.datatable-Cms').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index()).search(value, strict).draw();
            });
            $('.datatable thead select').on('change', function () {
                let strict = $(this).attr('strict') || false;
                var val    = $.fn.dataTable.util.escapeRegex(
                    $(this).val(),
                );

                table
                    .column($(this).parent().index())
                    .search(val, strict)
                    .draw();
            });
        });

    </script>
@endsection
