@extends('layout.mainlayout')
@section('content')
    @can('talk_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.talks.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.talk.title_singular') }}
                </a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'Talk', 'route' => 'admin.talks.parseCsvImport'])
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
                        <table class="table m-0 table-hover ajaxTable datatable datatable-Talk">
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
                                    {{--                                <th>--}}
                                    {{--                                    {{ trans('cruds.talk.fields.talk_type') }}--}}
                                    {{--                                </th>--}}
                                    <th>
                                        {{ trans('cruds.talk.fields.headline') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.talk.fields.duration') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.talk.fields.price') }}
                                    </th>
                                    {{--                                <th>--}}
                                    {{--                                    {{ trans('cruds.talk.fields.max_participiants') }}--}}
                                    {{--                                </th>--}}
                                    {{--                                <th>--}}
                                    {{--                                    {{ trans('cruds.talk.fields.finance_currencies') }}--}}
                                    {{--                                </th>--}}
                                    {{--                                <th>--}}
                                    {{--                                    {{ trans('cruds.talk.fields.billing_address') }}--}}
                                    {{--                                </th>--}}
                                    {{--                                <th>--}}
                                    {{--                                    {{ trans('cruds.billingAddress.fields.lastname') }}--}}
                                    {{--                                </th>--}}
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
                                        {{--                                    <select class="form-control search">--}}
                                        {{--                                        <option value>{{ trans('global.all') }}</option>--}}
                                        {{--                                        @foreach($users as $key => $item)--}}
                                        {{--                                            <option value="{{ $item }}">{{ $item }}</option>--}}
                                        {{--                                        @endforeach--}}
                                        {{--                                    </select>--}}
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        {{--                                    <select class="form-control search">--}}
                                        {{--                                        <option value>{{ trans('global.all') }}</option>--}}
                                        {{--                                        @foreach($languages as $key => $item)--}}
                                        {{--                                            <option value="{{ $item }}">{{ $item }}</option>--}}
                                        {{--                                        @endforeach--}}
                                        {{--                                    </select>--}}
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="form-control search">
                                            <option value>--</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control search">
                                            <option value>--</option>
                                            <option value="0">Voice</option>
                                            <option value="1">Video</option>
                                        </select>
                                    </td>
                                    {{--                                <td>--}}
                                    {{--                                    <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">--}}
                                    {{--                                </td>--}}
                                    <td>
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    {{--                                <td>--}}
                                    {{--                                    <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">--}}
                                    {{--                                </td>--}}
                                    {{--                                <td>--}}
                                    {{--                                    <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">--}}
                                    {{--                                </td>--}}
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
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            @can('talk_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton      = {
                text     : deleteButtonTrans,
                url      : "{{ route('admin.talks.massDestroy') }}",
                className: 'btn btn-danger',
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
                ajax         : "{{ route('admin.talks.index') }}",
                columns      : [
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'id', name: 'id' },
                    { data: 'email', name: 'email' },
                    { data: 'english', name: 'english' },
                    { data: 'anonym_call', name: 'anonym_call' },
                    { data: 'call_type', name: 'call_type' },
                    // { data: 'talk_type', name: 'talk_type' },
                    { data: 'headline', name: 'headline' },
                    { data: 'duration', name: 'duration' },
                    { data: 'price', name: 'price' },
                    // { data: 'max_participiants', name: 'max_participiants' },
                    // { data: 'finance_currencies_symbol', name: 'finance_currencies.symbol' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' },
                ],
                orderCellsTop: true,
                order        : [[1, 'desc']],
                pageLength   : 10,
            };
            let table             = $('.datatable-Talk').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                                              .columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw();
            });
        });

    </script>
@endsection
