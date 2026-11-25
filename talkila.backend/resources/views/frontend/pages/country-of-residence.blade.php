@extends('frontend.layouts.frontendlayout')
@section('content')



        <div class="oh posrelative">
            <div class="show-for-mobile">
                @include('frontend.partials.components.mobile-page-navigation-header', [
                    'page_title' => __('COUNTRY_OF_RESIDENCE'),
                    'page_back_link' => '/settings/profile',
                ])
            </div>
            @include('frontend.partials.components.settings-navigation-mobile')
            <div class="grid-container">
                <div class="setting-page white-box p16mob">
                    <div class="setting-inner">
                        <div class="grid-x w-100">
                            <div class='cell medium-12'>
                                <div class="setting-tabs">

                                    @include('frontend.partials.components.settings-menu', [
                                        'pointer' => __('COUNTRY_OF_RESIDENCE'),
                                        'loggedUserData' => $loggedUserData,
                                    ])
                                </div>



                                        <div class="grid-x">
                                            <div class="show-for-mobile mt8 w-100"></div>
                                            <h6 class="mb25 dn">
                                                {{ __('COUNTRY_OF_RESIDENCE_INFORMATION') }}</h6>
                                            <p class="subTitle w-100">
                                                {{ __('COUNTRY_OF_RESIDENCE_INFORMATION_DESCRIPTION') }}
                                            </p>
                                            <div class="cell small-12">
                                                <div class="setting-inner">
                                                    <div class="step-heading-wrap">
                                                        <h6 class="title-billing-info show-for-mobile">
                                                            {{ __('BILLING_INFORMATION') }}</h6>
                                                        <form id="countryOfResidence" method="POST">
                                                            <div class="cell small-12">
                                                                <div class="group">
                                                                    <select id="vat_id" class="default-select ok"
                                                                        name="vat_id" oninput="this.classList.add('ok')">

                                                                        @foreach ($taxes as $tax)
                                                                            <option value="{{ $tax->id }}"
                                                                                @if (!$user->vat_id && $tax->english == 'Germany') selected @endif
                                                                                @if ($user->vat_id == $tax->id) selected @endif>
                                                                                {{ $tax->name }} ({{ $tax->value }}%)
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')
                                                                    </div>
                                                                    <button type="button" class="clear-button"
                                                                        tabindex="-1">✖</button>
                                                                    <label
                                                                        class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                                                                    <span class="bar"></span>
                                                                    <label
                                                                        class="input-label select-label">{{ __('COUNTRY_OF_RESIDENCE') }}</label>
                                                                </div>


                                                            </div>
                                                        </form>
                                                        <hr class="pr24">
                                                        <div class="cell text-right pr24">

                                                            <button class="btn fr submit-button mb16"
                                                                onclick="submitForm()"> {{ __('SAVE') }} </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    let form = document.querySelector('form');
                    let token = document.querySelector('meta[name="csrf-token"]').content;
                    let bearer = document.querySelector('meta[name="access_token"]').content;
                    let vat_id = document.querySelector('#vat_id');

                    function serialize() {
                        return '_token=' + token + '&vat_id=' + vat_id.value
                    }

                    function submitForm() {
                        let xhr = new XMLHttpRequest();

                        xhr.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                let response = JSON.parse(this.responseText);

                                toastify(response.message);
                            }
                        };

                        xhr.open('POST', '{{ route('api.country-of-residence.update') }}');

                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.setRequestHeader('Authorization', bearer);

                        xhr.send(serialize());
                    }
                </script>
            </div>
        </div>


@endsection
