@can($addGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.store') }}" method="POST" style="display: inline-block;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="state" value="1">
        <input type="hidden" name="user_id" value="{{ $row->id }}">
        <input type="submit" class="btn btn-xs btn-primary rounded-0 mt-2 mr-2" value="{{ trans('global.add') }}">
    </form>
@endcan


