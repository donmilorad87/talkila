@can($viewGate)
    <a style="color:#fff;" class="btn btn-xs btn-primary rounded-0 mt-2 mr-2" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can($editGate)
    <a style="color:#fff;" class="btn btn-xs btn-info rounded-0 mt-2 mr-2" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan

@can($deleteGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger rounded-0 mt-2 mr-2" value="Soft {{ trans('global.delete') }}">
    </form>
@endcan
