
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
                                        <div class="not-found text-center">
                                        <img src="{{ asset('frontend/assets/img/payout.png') }}" alt="user" />
                                        <h5>{{ __('NO_TRANSACTIONS') }}</h5>
                                        <p>{{ __('TRANSACTIONS_MESSAGE_NO_CACH') }}</p>
                                        </div>