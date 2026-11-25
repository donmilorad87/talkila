@if($row->state == 0)
    @can($editGate)
        <form action="{{ route('admin.' . $crudRoutePart . '.updateStatus', $row->id) }}" method="POST" style="display: inline-block;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="status" value="1">
            <input type="submit" class="btn btn-xs btn-success rounded-0 mt-2 mr-2" value="{{ trans('global.approve') }}">
        </form>
    @endcan
    @can($editGate)
        <form action="{{ route('admin.' . $crudRoutePart . '.updateStatus', $row->id) }}" method="POST" style="display: inline-block;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="status" value="2">
            <input type="submit" class="btn btn-xs btn-danger rounded-0 mt-2 mr-2" value="{{ trans('global.decline') }}">
        </form>
    @endcan
@endif
