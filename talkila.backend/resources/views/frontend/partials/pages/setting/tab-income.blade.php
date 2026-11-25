<div class="grid-x">
    <div class='cell medium-12 large-12'>
        <div class="setting-inner">
            <div class="form-wrapper">
                <h6>{{ __('TRANSACTIONS') }}</h6>
                <p>{{ __('JTC_STEP_1') }}</p>
            </div>
            <table>
                <tbody>
                    <tr>
                        <td>@include('frontend.partials.svg.icons.course-payment')
                            <div class="table-inner-heading">{{ __('COURSE_PAYMENT') }} <br>
                                <span>{{ __('TODAY') }}</span>
                            </div>
                        </td>
                        <td>+ €15.00 </td>
                    </tr>
                    <tr>
                        <td>@include('frontend.partials.svg.icons.course-payment')
                            <div class="table-inner-heading">{{ __('COURSE_PAYMENT') }} <br>
                                <span>{{ __('YESTERDAY') }}</span>
                            </div>
                        </td>
                        <td>+ €55.00 </td>
                    </tr>
                    <tr>
                        <td>@include('frontend.partials.svg.icons.payout-id')
                            <div class="table-inner-heading">{{ __('YESTERDAY') }} ID 231546 <br>
                                <span>14.07.2020</span>
                            </div>
                        </td>
                        <td>- €12,055.00 </td>
                    </tr>
                    <tr>
                        <td>@include('frontend.partials.svg.icons.payout-id')
                            <div class="table-inner-heading">{{ __('PAYOUT') }} ID 231546 <br>
                                <span>14.07.2020</span>
                            </div>
                        </td>
                        <td>- €12,055.00 </td>
                    </tr>
                    <tr>
                        <td>@include('frontend.partials.svg.icons.course-payment')
                            <div class="table-inner-heading">{{ __('COURSE_PAYMENT') }} <br>
                                <span>11.07.2020</span>
                            </div>
                        </td>
                        <td>+ €55.00 </td>
                    </tr>
                    <tr>
                        <td>@include('frontend.partials.svg.icons.course-payment')
                            <div class="table-inner-heading">{{ __('COURSE_PAYMENT') }} <br>
                                <span>Today</span>
                            </div>
                        </td>
                        <td>+ €15.00 </td>
                    </tr>
                    <tr>
                        <td>@include('frontend.partials.svg.icons.course-payment')
                            <div class="table-inner-heading">{{ __('COURSE_PAYMENT') }} <br>
                                <span>Yesterday</span>
                            </div>
                        </td>
                        <td>+ €55.00 </td>
                    </tr>
                    <tr>
                        <td>@include('frontend.partials.svg.icons.payout-id')
                            <div class="table-inner-heading">{{ __('PAYOUT') }} ID 231546 <br>
                                <span>14.07.2020</span>
                            </div>
                        </td>
                        <td>- €12,055.00 </td>
                    </tr>
                    <tr>
                        <td>@include('frontend.partials.svg.icons.payout-id')
                            <div class="table-inner-heading">{{ __('PAYOUT') }} ID 231546 <br>
                                <span>14.07.2020</span>
                            </div>
                        </td>
                        <td>- €12,055.00 </td>
                    </tr>
                    <tr>
                        <td>@include('frontend.partials.svg.icons.course-payment')
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
                        <li><a href="#" aria-label="arrow-right"><img src="./assets/img/arrow-right-pn.svg" alt=""></a>
                        </li>
                        <li class="active"><a href="#" aria-label="Page 1">1</a></li>
                        <li><a href="#" aria-label="Page 2">2</a></li>
                        <li><a href="#" aria-label="Page 3">3</a></li>
                        <li><a href="#" aria-label="arrow-left"><img src="./assets/img/arrow-left-pn.svg" alt=""></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
