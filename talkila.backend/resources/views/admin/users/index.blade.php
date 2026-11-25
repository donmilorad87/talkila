@extends('layout.mainlayout')
@section('content')
    <style>
        tr > *:first-child {
            display : none;
        }
    </style>
@can('user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<!-- Stats Card -->
<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="stats-card-one mb-30">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-10 line-height-1">Users total</p>
                    <h3 class="mb-0 fs-25">{{ number_format($totalUsers, 0) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6">
        <div class="stats-card-one mb-30">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-10 line-height-1">Teacher</p>
                    <h3 class="mb-0 fs-25">{{ $aTeacherUsers }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6">
        <div class="stats-card-one mb-30">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-10 line-height-1">Incomplete Registration</p>
                    <h3 class="mb-0 fs-25">0</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6">
        <div class="stats-card-one mb-30">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-10 line-height-1">New Users today</p>
                    <h3 class="mb-0 fs-25"> {{ $nTotalUsersToday }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Stats Card -->

<!-- Data Table -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-User">
                        <thead>
                          <tr>
                            <th>

                            </th>
                            <th style="max-width: 75px">
                                {{ trans('cruds.user.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.user.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.user.fields.email') }}
                            </th>
                            <th style="max-width: 75px">
                              {{ trans('cruds.user.fields.sold_talks') }}
                            </th>
                            <th style="max-width: 75px">
                              {{ trans('cruds.user.fields.followers') }}
                            </th>
                            <th>
                              {{ trans('cruds.user.fields.state.title') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                          </tr>
                          <tr>
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
                              <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                              <select class="form-control" name="state" id="state">
                                <option value>- -</option>
                                <option value="1">account activated</option>
                                <option value="2">spam</option>
                                <option value="3">blocked</option>
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
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
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
    aaSorting: [],
    ajax: "{{ route('admin.users.index') }}",
    columns: [
    { data: 'placeholder', name: 'placeholder' },
    { name: 'id',
      data: function (data, type, row) {
        return '<a class="link" href="users/'+data.id+'/edit">'+data.id+'</a>';
      }
    },
    { name: 'name',
        data: function (data, type, row) {
            return '<a class="link" href="users/' + data.id + '/edit">' + data.name + '</a>';
        },
    },
    { data: 'email', name: 'email' },
    { data: 'total_talk_income', name: 'total_talk_income' },
    { data: 'amount_of_followers', name: 'amount_of_followers' },
{
  data: 'state',
  render: function(data) {
    switch(data) {
      case 1:
        return '<span class="success-color">account&nbsp;activated</span>'
        break;
      case 2:
        return '<span class="warning-color">spam</span>'
        break;
      case 3:
        return '<span class="danger-color">blocked</span>'
        break;
      default:
        return ''
    }
  }
},
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    aoColumnDefs: [
        { "bSortable": false, "aTargets": [ 0, 4, 5, 7 ] },
    ],
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-User').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  $('.datatable thead select').on('change', function () {
    let strict = $(this).attr('strict') || false
    var val = $.fn.dataTable.util.escapeRegex(
      $(this).val()
    );

    table
      .column($(this).parent().index())
      .search(val, strict)
      .draw()
  });
  $('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value
      table
        .column($(this).parent().index())
        .search(value, strict)
        .draw()
  });
});

    </script>
@endsection