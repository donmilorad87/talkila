@if (!empty($userExperience) && (!empty($userExperience['education']) || !empty($userExperience['job']) ))
    <section class="cell small-12 profileExperienceContainer">
        <h5 class="profExperience mb16">{{ explode(' ', $user->name)[0] }}{{ __('EXPERIENCE_CV') }}</h5>

        <div class="wrapper-video">
            <div class="inner-video">
                <div class="grid-x">




                        <div class="fl w-100 posrelative">


                            <ul class="experience_inner">
                                @foreach ($userExperience['education'] as $education)
                                    <li>
                                        <h5>{{ $education['company_name'] }} </h5>
                                        <p>{{ $education['location'] }}</p>
                                        <p>{{ $education['start_date'] }} -
                                            {{ !empty($education['end_date']) ? $education['end_date'] : (empty($education['end_date']) && $education['work_here'] ? 'ongoing' : '') }}
                                        </p>
                                    </li>
                                @endforeach
                                @if (!empty($userExperience) && !empty($userExperience['job']))

                                    @foreach ($userExperience['job'] as $job)
                                        <li>
                                            <h5>{{ $job['company_name'] }} </h5>
                                            <p>{{ $job['location'] }}</p>
                                            <p>{{ $job['start_date'] }} -
                                                {{ !empty($job['end_date']) ? $job['end_date'] : (empty($job['end_date']) && $job['work_here'] ? 'ongoing' : '') }}
                                            </p>
                                        </li>
                                    @endforeach

                                @endif



                            </ul>
                            @include('frontend.partials.svg.icons.dashed_line')
                        </div>


                </div>
            </div>
        </div>
    </section>
    @endif
