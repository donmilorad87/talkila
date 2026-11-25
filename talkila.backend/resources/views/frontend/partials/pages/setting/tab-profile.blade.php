<div class="grid-x">
    <div class='cell medium-12 large-8'>
        <div class="setting-inner">
            <div class="form-wrapper">
                <h6>{{ __('PROFILE_SETTINGS') }}s</h6>
                <p>{{ __('JTC_STEP_1') }}</p>
                <div class="small-12">
                    <div class="media-object meida-mg">
                        <div class="media-object-section">
                            <div class="thumbnail">
                                <img src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />
                            </div>
                        </div>
                        <div class="media-object-section main-section">
                            <p><strong>{{ __('UPLOAD_NEW_PHOTO') }} - {{ __('REMOVE_PHOTO') }} </strong></p>
                            <p>{{ __('PHOTE_HELP_TEXT') }}</p>
                        </div>
                    </div>
                </div>
                <div class="small-12">
                    <form class="form-option">
                        <div class="grid-x grid-padding-x">
                            <div class="medium-6 cell">
                                <label>{{ __('YOUR_NAME') }}
                                    <input type="text" placeholder="Helen Tran">
                                </label>
                            </div>
                            <div class="medium-6 cell">
                                <label>{{ __('USERNAME') }}
                                    <input type="text" placeholder="username1988">
                                </label>
                            </div>
                            <div class="medium-6 cell">
                                <label>{{ __('EMAIL') }}
                                    <input type="text" placeholder="helentran@yahoo.com">
                                </label>
                            </div>
                            <div class="medium-6 cell">
                                <label>{{ __('PROFESSION') }}
                                    <select>
                                        <option value="showboat">{{ __('PROFILE_GERMAN_LANGUAGE_SUPPLIER') }}</option>
                                        <option value="redwing">1</option>
                                        <option value="narcho">2</option>
                                        <option value="hardball">3</option>
                                    </select>
                                </label>
                            </div>
                            <div class="medium-12 cell">
                                <label>{{ __('ABOUT_ME') }} ({{ __('BIO') }})
                                    <textarea placeholder="" rows="4"></textarea>
                                </label>
                            </div>
                            <hr>
                            <div class="medium-6 cell">
                                <label>{{ __('PASSWORD') }}
                                    <input type="text" placeholder="************************">
                                </label>
                            </div>
                            <div class="medium-6 cell">
                                <label>{{ __('NEW_PASSWORD') }}
                                    <input type="text" placeholder="helentran@yahoo.com">
                                </label>
                            </div>
                            <div class="medium-6 cell">
                                <label>{{ __('OLD_PASSWORD') }}
                                    <input type="text" placeholder="helentran@yahoo.com">
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-12 cell">
                <div class="table-details">
                    <h6>{{ __('VERIFICATION_REQUEST_HISTORY') }}</h6>
                    <table>
                        <thead>
                            <tr>
                                <th>{{ __('NAME') }}</th>
                                <th>{{ __('DATE') }}</th>
                                <th class="text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Helen Tran</td>
                                <td>09/08/2020</td>
                                <td class="text-danger">{{ __('DECLINED') }}</td>
                            </tr>
                            <tr>
                                <td>Helen Tran</td>
                                <td>09/08/2020</td>
                                <td>{{ __('PENDING') }}</td>
                            </tr>
                            <tr>
                                <td>Helen Tran</td>
                                <td>09/08/2020</td>
                                <td>{{ __('PENDING') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class='cell medium-12 large-4'>
        @include('frontend.partials.pages.setting.profile-progess')
    </div>
</div>
