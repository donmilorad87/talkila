<div class="media-object meida-mg">
    <div class="icon-sn book-sn-icon box-resize">
        <div class="posrelative loggedPic cp uldrar profPict" data-popup="uploadDropArea">

            @if(!empty(auth()->user()->profile_picture) || !empty(auth()->user()->profile_picture_tmp))
                <img src="{{ auth()->user()->profile_picture ?? auth()->user()->profile_picture_tmp }}" alt="{{auth()->user()->name}}" />
            @else
                @include('frontend.partials.svg.icons.no-profile-picture')
            @endif

            @include('frontend.partials.svg.icons.profile-pic-plus')

        </div>
    </div>

        <div class="media-object-section main-section">
            <p class="uploadPhotoTextHolder">
                @csrf
                <strong class="cp" data-popup="uploadDropArea">{{ __('UPLOAD_NEW_PHOTO') }}</strong>
                @if(!empty(auth()->user()->profile_picture))
                    <span class="middleLine"> - </span>
                    <strong id="removePhoto"> {{ __('REMOVE_PHOTO') }} </strong>
                @endif
            </p>
            <p class="photoHelpText">{{ __('PHOTE_HELP_TEXT') }}</p>
        </div>




</div>
