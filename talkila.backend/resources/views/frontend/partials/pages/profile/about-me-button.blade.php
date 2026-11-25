<div class="f1 @if ($userData['id'] == auth()->user()->id) small-10 @else small-10 @endif large-8">
    <div class="bwhite mr4p14 abmebutton">
        <h6 class="talignc w-100 ">
            <a class="about_my_Butt" href="{{route('about_me')}}"> {{ __('ABOUT_ME') }} </a>
        </h6>
    </div>
</div>
