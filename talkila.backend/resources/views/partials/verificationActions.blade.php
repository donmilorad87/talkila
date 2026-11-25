@if($viewUser)
    <a style="color:#fff;" class="btn btn-xs btn-primary rounded-0 mt-2 mr-2" href="{{ route('admin.' . $crudRoutePart . '.show', $row->user_id) }}">
        {{ trans('global.view') }}
    </a>
@endif
@if($approveVerification)
    <form action="{{ route('admin.' . $crudRoutePart . '.approve', ['id' => $row->id]) }}" method="POST" style="display: inline-block;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-primary rounded-0 mt-2 mr-2" value="{{ trans('global.approve') }}">
    </form>
@endif
@if($disapproveVerification)
    <form action="{{ route('admin.' . $crudRoutePart . '.disapprove', ['id' => $row->id]) }}" method="POST" style="display: inline-block;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger rounded-0 mt-2 mr-2" value="{{ trans('global.disapprove') }}">
    </form>
@endif
