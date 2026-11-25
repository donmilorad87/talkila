@if($viewGate)
    <a style="color:#fff;" class="btn btn-xs btn-primary rounded-0 mt-2 mr-2" href="{{ route('affiliate.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endif
@if($editGate)
    <a style="color:#fff;" class="btn btn-xs btn-info rounded-0 mt-2 mr-2" href="{{ route('affiliate.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a>
@endif
@if($deleteGate)
    <form action="{{ route('affiliate.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger rounded-0 mt-2 mr-2" value="{{ trans('global.delete') }}">
    </form>
@endif

