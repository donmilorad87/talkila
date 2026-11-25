@if(isset($userTalks))

    <div class="course-item">
        @php

            if (!empty($editTalk)) {
                $routePath = route('jtc_create_your_first_talk', ['id' => $userTalks['id']]);
            } elseif (!empty($bookTalk)) {
                $routePath = route('book_slot', $userTalks['id']);
            } else {
                $routePath = null;
            }



        @endphp

        <a data-talk-id="{{ $userTalks['id'] }}" @if (!empty($routePath)) href="{{ $routePath }}" @endif class="dataTalkId">
            <h6>{{ $userTalks['headline'] }} </h6>



        </a>
    </div>
@else

@endif
