@can($editGate)
    <a style="color:#fff;" class="btn btn-xs btn-info rounded-0 mt-2 mr-2" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan


