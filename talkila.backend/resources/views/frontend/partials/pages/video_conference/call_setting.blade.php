<div class="popupBase" id="callSetting">
   <div class="popuper popup-sm">
      
<div class="credit-model" id="call-settings" data-reveal>
    <div class="grid-x grid-padding-x">
        <div class="cell small-12 medium-12 large-12">
            <h1>Call Settings</h1>
        </div>
    </div>
    <br>

    <form class="form-field">


        <div class="grid-x grid-padding-x">


            <div class="cell small-12 medium-12 large-12">
                <h5>Audio</h5>
            </div>


            <div class="cell small-12 medium-12 large-6">
                <label>Input Device
                    <select>
                        <option value="showboat">Microphone (High Definition Audio...</option>
                        <option value="redwing">2</option>
                        <option value="narcho">3</option>
                        <option value="hardball">4</option>
                    </select>
                </label>
            </div>

            <div class="cell small-12 medium-12 large-6">
                <label>Output Device
                    <select>
                        <option value="showboat">Default</option>
                        <option value="redwing">2</option>
                        <option value="narcho">3</option>
                        <option value="hardball">4</option>
                    </select>
                </label>
            </div>
            
            {{-- This comment will not be present in the rendered HTML --}}

            <div class="cell small-12 medium-12 large-6">
                <label>Input Volume</label>

                <div class="slider range-slier" data-slider data-initial-start="50" data-end="200">
  <span class="slider-handle"  data-slider-handle role="slider" tabindex="1"></span>
  <span class="slider-fill" data-slider-fill></span>
  <input type="hidden">
</div>


            </div>


            <div class="cell small-12 medium-12 large-6">
                <label>Output Volume</label>
                <div class="slider range-slier" data-slider data-initial-start="50" data-end="200">
  <span class="slider-handle"  data-slider-handle role="slider" tabindex="1"></span>
  <span class="slider-fill" data-slider-fill></span>
  <input type="hidden">
</div>

            </div>

            <div class="cell  small-12 medium-12 large-12">
                <div class="text-heading-no">
                    <p>Mic Test</p>
                    <p>Having mic issues? Start a test and say something fun, we’ll play your voice back at you</p>
                </div>
            </div>



            <div class="cell  small-12 medium-12 large-12">

                <div class="text-right d-flex">
                    <a class="hollow button" href="#">Let’s Check</a>
                    <div class="line-check">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>

                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>


                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>

                    </div>
                </div>

            </div>


            <div class="cell small-12 medium-12 large-12">
                <label>Input Mode
                    <select>
                        <option value="showboat">Voice Activity</option>
                        <option value="redwing">2</option>
                        <option value="narcho">3</option>
                        <option value="hardball">4</option>
                    </select>
                </label>
            </div>

            <br>

            <div class="cell small-12 medium-12 large-12">
                <h5>Video</h5>
            </div>

            <div class="cell small-12 medium-12 large-7">
                <label>Input Mode
                    <select>
                        <option value="showboat">Video Hardware Not Found</option>
                        <option value="redwing">2</option>
                        <option value="narcho">3</option>
                        <option value="hardball">4</option>
                    </select>
                </label>


                <div class="text-right d-flex">
                    <a class="hollow button my-0" href="#">Test Video</a>
                </div>
            </div>

            <div class="cell small-12 medium-12 large-5">
            @include('frontend.partials.svg.icons.video-frame')
            </div>

        </div>

    </form>

</div>
      <span class="closeSpanPopup">×</span>
   </div>
</div>