<div class="drop-area" data-dropdown-id={{ $id }}>
    <div class="my-form">
        <input type="file" class="dn fileInputs" id="fileElem{{ $id }}" {{-- multiple --}} accept="image/*" oninput="handleFiles(this.files, this)" required>
        <label class="uploadButton" for="fileElem{{ $id }}">@include('frontend.partials.svg.icons.upload-yellow') <h5>{{ __('UPLOAD_IMAGE') }}</h5> </label>
    </div>

    <div class="fl w-100 uplcnt">
        @include('frontend.partials.svg.icons.upload-file')
        <p>{{ __('UPLOADING') }}</p>
        <progress id="progress-bar" max=100 value=0></progress>
    </div>
    <div class="gallery">
        <span class="icon-deletes" data-pointer='{{$pointer ?? ''}}'>@include('frontend.partials.svg.icons.delete')</span>
    </div>
</div>
<div id="uploadValidationMessage" class="hiddenDivScale df aic fl"></div>
