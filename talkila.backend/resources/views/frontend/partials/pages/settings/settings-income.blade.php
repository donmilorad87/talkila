<div class="setting-page white-box p16mob">

    {{-- <div class="hide-for-medium">
        <div class="d-flex right-left-wrap">
            <a href="/settings/mobile">
                @include('frontend.partials.svg.icons.arrow-left')</a>
            <p>{{ __('FOOTER_LINK_INCOME') }}</p>
            <p></p>
        </div>
    </div> --}}
    <div class="setting-inner">
        <div class="grid-x grid-margin-x">
            <div class='cell medium-12'>
                <div class="setting-tabs">

                    <div class="show-for-medium">
                        @include('frontend.partials.components.settings-menu', ['pointer' => __('SET_ACCOUNTING')])
                    </div>

                    <div class="tabs-content">
                        <div class="tabs-panel is-active" id="Profile">
                            <div class="grid-x">
                                <div class='cell medium-12 large-12'>
                                    <div class="setting-inner">

                                        <div class="show-for-medium">

                                            <p class="subTitle">{{ __('JTC_STEP_1') }}</p>
                                        </div>

                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td width="75%">@include('frontend.partials.svg.icons.course-payment')
                                                        <div class="table-inner-heading">{{ __('TALK_PAYMENT') }} <br>
                                                            <span>{{ __('TODAY') }}</span>
                                                        </div>
                                                    </td>
                                                    <td>+ €15.00 </td>
                                                </tr>
                                                <tr>
                                                    <td width="75%">@include('frontend.partials.svg.icons.course-payment')
                                                        <div class="table-inner-heading">{{ __('TALK_PAYMENT') }} <br>
                                                            <span>{{ __('YESTERDAY') }}</span>
                                                        </div>
                                                    </td>
                                                    <td>+ €55.00 </td>
                                                </tr>
                                                <tr>
                                                    <td width="75%">@include('frontend.partials.svg.icons.payout-id')
                                                        <div class="table-inner-heading">{{ __('PAYOUT') }} ID 231546 <br>
                                                            <span>14.07.2020</span>
                                                        </div>
                                                    </td>
                                                    <td>- €12,055.00 </td>
                                                </tr>
                                                <tr>
                                                    <td width="75%">@include('frontend.partials.svg.icons.payout-id')
                                                        <div class="table-inner-heading">{{ __('PAYOUT') }} ID 231546 <br>
                                                            <span>14.07.2020</span>
                                                        </div>
                                                    </td>
                                                    <td>- €12,055.00 </td>
                                                </tr>
                                                <tr>
                                                    <td width="75%">@include('frontend.partials.svg.icons.course-payment')
                                                        <div class="table-inner-heading">{{ __('COURSE_PAYMENT') }} <br>
                                                            <span>11.07.2020</span>
                                                        </div>
                                                    </td>
                                                    <td>+ €55.00 </td>
                                                </tr>
                                                <tr>
                                                    <td width="75%">@include('frontend.partials.svg.icons.course-payment')
                                                        <div class="table-inner-heading">{{ __('COURSE_PAYMENT') }} <br>
                                                            <span>{{ __('TODAY') }}</span>
                                                        </div>
                                                    </td>
                                                    <td>+ €15.00 </td>
                                                </tr>
                                                <tr>
                                                    <td width="75%">@include('frontend.partials.svg.icons.course-payment')
                                                        <div class="table-inner-heading">{{ __('COURSE_PAYMENT') }} <br>
                                                            <span>{{ __('YESTERDAY') }}</span>
                                                        </div>
                                                    </td>
                                                    <td>+ €55.00 </td>
                                                </tr>
                                                <tr>
                                                    <td width="75%">@include('frontend.partials.svg.icons.payout-id')
                                                        <div class="table-inner-heading">{{ __('PAYOUT') }} ID 231546 <br>
                                                            <span>14.07.2020</span>
                                                        </div>
                                                    </td>
                                                    <td>- €12,055.00 </td>
                                                </tr>
                                                <tr>
                                                    <td width="75%">@include('frontend.partials.svg.icons.payout-id')
                                                        <div class="table-inner-heading">{{ __('PAYOUT') }} ID 231546 <br>
                                                            <span>14.07.2020</span>
                                                        </div>
                                                    </td>
                                                    <td>- €12,055.00 </td>
                                                </tr>
                                                <tr>
                                                    <td width="75%">@include('frontend.partials.svg.icons.course-payment')
                                                        <div class="table-inner-heading">{{ __('COURSE_PAYMENT') }} <br>
                                                            <span>11.07.2020</span>
                                                        </div>
                                                    </td>
                                                    <td>+ €55.00 </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="pagination-wrap">
                                            <div class="pagination-previous disabled">{{ __('PAGINATION_SHOW_RESULTS') }}
                                            </div>
                                            <nav aria-label="Pagination">
                                                <ul class="pagination">
                                                    <li><a href="#" aria-label="arrow-right"><img
                                                                src="./assets/img/arrow-right-pn.svg" alt=""></a>
                                                    </li>
                                                    <li class="active"><a href="#" aria-label="Page 1">1</a></li>
                                                    <li><a href="#" aria-label="Page 2">2</a></li>
                                                    <li><a href="#" aria-label="Page 3">3</a></li>
                                                    <li><a href="#" aria-label="arrow-left"><img
                                                                src="./assets/img/arrow-left-pn.svg" alt=""></a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
