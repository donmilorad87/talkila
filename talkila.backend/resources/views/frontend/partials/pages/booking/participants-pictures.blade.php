<div class="profile-img-box">

    <img class="fl" src="@if($item['profile_picture']) {{$item['profile_picture']}}@else {{env('USER_DEFAULT_IMAGE')}}@endif" alt="user" />
    <h5 class="ml8 bookingDetailsUsername">{{ $item['headline'] }}</h5>

</div>
