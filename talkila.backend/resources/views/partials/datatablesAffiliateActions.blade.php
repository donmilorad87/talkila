
@if($row->approved)
    <a style="color:#fff;" class="btn btn-xs btn-danger rounded-0 mt-2 mr-2" href="{{ route('admin.users.actionAffiliate', ['user' => $row, 'state' => 0]) }}">
        Disapprove
    </a>
@else
    <a style="color:#fff;" class="btn btn-xs btn-info rounded-0 mt-2 mr-2" href="{{ route('admin.users.actionAffiliate', ['user' => $row, 'state' => 1]) }}">
        Approve
    </a>
@endif

