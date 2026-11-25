@if ($user->id !== $item['teacher_id'])
    <div class="optionButton" data-opened="0">
        @include('frontend.partials.svg.icons.v-dots')
        <ul>

            <li class="noselect cp" data-popup="classDetails-{{ $item['id'] }}"> {{ __('REBOOK_TALK') }}
            </li>

            {{-- <li class="noselect"> {{ __('MARK_AS_NO_SHOW') }} </li> --}}
        </ul>
    </div>
@endif
