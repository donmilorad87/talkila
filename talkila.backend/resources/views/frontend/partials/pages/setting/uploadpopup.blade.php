<div class="popupBase" id="uploadPopUp" data-opened="0">
   <div class="popuper popup-xs">
   <div class="credit-model">
                    <h1>{{ __('VERIFY_IDENTITY') }}</h1>
                    <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer.
                    </p>

                    <form class="form-option">

                        <div class="grid-x">

                            <div class="medium-12  small-12">
                                <label>{{ __('YOUR_NAME') }}
                                    <input type="text" placeholder="Helen Tran">
                                </label>
                            </div>

                            <div class="medium-12 small-12">

                                <div class="image-upload-wrap">
                                    <input class="file-upload-input" type="file" onchange="readURL(this);"
                                        accept="image/*">
                                    <div class="drag-text">
                                    @include('frontend.partials.svg.icons.upload-yellow')
                                        <h3>{{ __('UPLOAD_IMAGE') }}</h3>
                                    </div>

                                    <div class="drag-text uploading-filed">
                                    @include('frontend.partials.svg.icons.upload-file')

                                        <div class="uploading-wrap">
                                            <h3>{{ __('UPLOADING') }}</h3>
                                            <div class="warning progress">
                                                <div class="progress-meter" style="width: 100%"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="medium-12 small-12">

                                <div class="image-upload-wrap profile-filed">
                                    <div class="drag-text">
                                    <img src="{{ asset('frontend/assets/img/id.jpg') }}" alt="user" />
                                        <a href='#' class="icon-delete">@include('frontend.partials.svg.icons.delete')</a>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="grid-x ">
                            <div class="large-3"></div>
                            <div class="large-6 small-12">
                                <div class="text-center">
                                    <a class="btn expanded" data-open="exampleModal3">{{ __('SUBMIT_DOCUMENTS') }}</a>
                                </div>
                            </div>
                            <div class="large-3"></div>
                        </div>

                    </form>
                </div>
      <span class="closeSpanPopup">×</span>
   </div>
</div>
