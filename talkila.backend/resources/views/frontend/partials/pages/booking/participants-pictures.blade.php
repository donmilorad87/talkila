<div class="profile-img-box">

    <img class="fl" src="@if($item['profile_picture']) {{$item['profile_picture']}}@else {{config('app.default_image')}}@endif" alt="user" />
    <h5 class="ml8 bookingDetailsUsername">{{ $item['headline'] }}</h5>

</div>
