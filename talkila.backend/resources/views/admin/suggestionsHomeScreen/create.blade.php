@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('cruds.suggestionsHomeScreen.title_add_new_customers') }}</h5>
                </div>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.suggestions-home-screen.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-suggestionsHomeScreen">
                        <thead>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.username') }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.profession') }}
                                </th>
                                <th>
                                    {{ trans('cruds.userFollowed.fields.follower') }}
                                </th>
                                <th>
                                    {{ trans('cruds.booking.title') }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.visibility.title') }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.verified') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search form-control" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                            </td>
                            <td>
                            </td>
                            <td>
                                <select class="search form-control">
                                  <option value>{{ trans('global.all') }}</option>
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                                </select>
                            </td>
                            <td>
                                <select class="search form-control">
                                  <option value>{{ trans('global.all') }}</option>
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                                </select>
                            </td>
                            <td>
                            </td>
                            </tr>
                        </thead>
                    </table>
                </div><br>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.suggestions-home-screen.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
$(function () {
    let dtOverrideGlobals = {
            processing: true,
            serverSide: false,
            retrieve: true,
            aaSorting: [],
            ajax: "{{ route('admin.suggestions-home-screen.create') }}",
            columns: [
                { data: 'username', name: 'username' },
                { data: 'profession', name: 'profession' },
                { data: 'followers', name: 'followers' },
                { data: 'bookings', name: 'bookings' },
                { 
                  data: 'visibility', 
                  name: 'visibility', 
                  render: function(data) { 
                    switch(data) {
                      case 1:
                        return 'Yes'
                        break;
                      case 0:
                        return 'No'
                        break;
                      default:
                        return ''
                    }


                  },
                },
                { 
                  data: 'verified',
                  name: 'verified',
                  render: function(data) { 
                    switch(data) {
                      case 1:
                        return 'Yes'
                        break;
                      case 0:
                        return 'No'
                        break;
                      default:
                        return ''
                    }


                  },
                },
                {
                    name: 'actions',
                    data: function (data, type, row) {
                    switch(data.suggestions_home_screen.length) {
                      case 0:
                        return  data.actions 
                        break;
                      default:
                        return ''
                        }
                    }
                },
            ],
            orderCellsTop: true,
            order: [[ 1, 'asc' ]],
            pageLength: 10,
        };
    let table = $('.datatable-suggestionsHomeScreen').DataTable(dtOverrideGlobals);
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
    $('.datatable thead select').on('change', function () {
        let strict = $(this).attr('strict') || false
        var value = $.fn.dataTable.util.escapeRegex(
            $(this).val()
        );

        table
            .column($(this).parent().index())
            .search(value, strict)
            .draw()
    });
});
</script>
@endsection
