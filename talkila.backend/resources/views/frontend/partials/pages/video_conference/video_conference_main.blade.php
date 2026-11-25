<div class="tabs-content" data-tabs-content="collapsing-tabs">


    <div class="">

        <div class="small-12">

            <ul class="tabs tabs-re-manage" data-active-collapse="false" data-tabs id="collapsing-tabs">
                <li class="tabs-title1"><a class="view-btn">View Us</a></li>
                <li class="tabs-title is-active"><a href="#screen-1" aria-selected="true"> @include('frontend.partials.svg.icons.video_laptop') </a></li>
                <li class="tabs-title"><a href="#screen-2"> @include('frontend.partials.svg.icons.video_grid') </a></li>
            </ul>

        </div>

    </div>


    <div class="tabs-panel is-active confefence-video-inner" id="screen-1">
            @include('frontend.partials.pages.video_conference.view_one')


    </div>

    <div class="tabs-panel " id="screen-2">
            @include('frontend.partials.pages.video_conference.view_two')


    </div>


</div>

@include('frontend.partials.pages.video_conference.chat_box')


@include('frontend.partials.pages.video_conference.notification')

@include('frontend.partials.pages.video_conference.call_setting')

