

<form class="form-option" id="billing-information-form" autocomplete="off">
    @csrf
    <div class="grid-x grid-margin-x">
        @if (!empty($userAccounting))
            <div class="cell small-12">
                <div class="group">
                    <input class="default-input" type="hidden" name="accountingId" required
                        value="{{ $userAccounting['id'] }}" autocomplete="off" />
                </div>

            </div>
        @endif

        <div class="cell small-12">
            <div class="group">
                <input class="default-input ok" type="text" name="name" required
                    @if (!empty($userAccounting)) value="{{ $userAccounting['company_name'] }}" @else value="{{ $user['name'] }}" @endif
                    autocomplete="off" />
                <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                <button type="button" class="clear-button" tabindex="-1">✖</button>
                <label class="count-label">0/50</label>
                <label class="default-warn">{{ __('STEP') }}</label>
                <span class="bar"></span>
                <label class="input-label">{{ __('YOUR_NAME') }}</label>
            </div>

        </div>

        <div class="cell small-12">
            <div class="group">
                <textarea class="default-textarea {{ !empty($userAccounting['street']) ? 'ok' : '' }}" type="text" name="address"
                    required autocomplete="off">@if (!empty($userAccounting)){{ $userAccounting['street'] }}@endif
                </textarea>
                <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                <label class="count-label">0/100</label>
                <label class="default-warn">{{ __('VALIDATION_MIN_4_MAX_50') }}</label>
                <button type="button" class="clear-button" tabindex="-1">✖</button>
                <span class="bar"></span>
                <label class="input-label">{{ __('ADDRESS') }}</label>
            </div>

        </div>
        <div class="cell small-12">


            <div class="group">
                <input class="default-input {{ !empty($userAccounting['city']) ? 'ok' : '' }}" type="text"
                    name="city" required
                    @if (!empty($userAccounting)) value="{{ $userAccounting['city'] }}" @endif
                    autocomplete="off" />
                <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                <button type="button" class="clear-button" tabindex="-1">✖</button>
                <label class="count-label">0/50</label>
                <label class="default-warn">{{ __('VALIDATION_MIN_1_MAX_50') }}</label>
                <span class="bar"></span>
                <label class="input-label">{{ __('CITY') }}</label>
            </div>

        </div>
        <div class="cell small-12">
            <div class="group">
                <input class="default-input {{ !empty($userAccounting['zipcode']) ? 'ok' : '' }}" type="text"
                    name="zipCode" required
                    @if (!empty($userAccounting)) value="{{ $userAccounting['zipcode'] }}" @endif
                    autocomplete="off" />
                <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                <button type="button" class="clear-button" tabindex="-1">✖</button>
                <label class="count-label">0/50</label>
                <label class="default-warn">{{ __('VALIDATION_MIN_1_MAX_50') }}</label>
                <span class="bar"></span>
                <label class="input-label">{{ __('ZIP_CODE') }}</label>
            </div>

        </div>
        <div class="cell small-12">
            <div class="group">
                <input class="default-input {{ !empty($userAccounting['tax_number']) ? 'ok' : '' }}" type="text"
                    name="vatId" placeholder="{{ __('PLACEHOLDER_TAX_ID') }}" required
                    @if (!empty($userAccounting)) value="{{ $userAccounting['tax_number'] }}" @endif
                    autocomplete="off" />
                <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                <label class="count-label">0/50</label>
                <button type="button" class="clear-button" tabindex="-1">✖</button>
                <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                <span class="bar"></span>
                <label class="input-label">{{ __('TAX_ID') }}</label>
            </div>

        </div>

        <div class="cell small-12">
            <div class="group">

                <select id="country" class="default-select ok" name="country">
                    <option class="dn" value=""></option>


                    @foreach ($countries as $country)
                        <option value="{{ $country['id'] }}" data-value="{{ $country['value'] }}"
                            data-country_code="{{ $country['country_code'] }}"
                            @if (!empty($userAccounting) && $userAccounting['countries_id'] == $country['id']) selected @else @if ($country['id'] == 20) selected @endif
                            @endif>
                            {{ $country['country'] }}</option>
                    @endforeach
                </select>
                <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                <button type="button" class="clear-button" tabindex="-1">✖</button>
                <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                <span class="bar"></span>
                <label class="input-label select-label">{{ __('COUNTRY') }}</label>
            </div>

        </div>


        @if (
            ($user->roles->first()->id === UserRoles::TEACHER && $user->jtc?->state) ||
            ($user->jtc?->jtc_started &&
                $user->jtc?->step_1 &&
                $user->jtc?->step_2 &&
                $user->jtc?->step_3 &&
                $user->jtc?->step_4) &&
            (Route::current()->getName() !== 'book_slot_payment' && Route::current()->getName() !== 'video_conference'))

            <div class="cell small-12 vat_checkboxer">
                <div class="group">
                    <p>
                        @lang('VAT_CHECKBOX_DESCRIPTION')
                    </p>
                    <label class="vat_cb_label w-100 df aic g1rem" for="vat_cb">
                        <input type="checkbox" id="vat_cb" name="vat_cb" class="m0 p0 df aic jcc"
                            @if (!empty($userAccounting['pays_vat']) && $userAccounting['pays_vat']) checked @endif>
                        <span>@lang('VAT_CHECKBOX_LABEL')</span>
                    </label>
                </div>

            </div>

        @endif

    </div>


    @php
        $klijetForma = '';
        if (Route::current()->getName() !== 'jtc_set_accounting' && $user->type === \App\Entity\UserTypes::CLIENT) {
            $klijetForma = 'kormorana';
        }
    @endphp
    <input type="hidden" id="clientForma" value="{{ $klijetForma }}" />

</form>
