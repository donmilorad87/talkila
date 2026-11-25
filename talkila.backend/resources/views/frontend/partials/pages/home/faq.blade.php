<section class="accounts-content bwhite" id="faqSelection">
    <div class="grid-container">
        <div>
            <h2 class="heading-title-fq show-for-small-only text-center tac mt3rem">{{ __('FAQ_HEADLINE_MOBILE') }}</h2>
            @if (Route::current()->getName() == 'home')
                <h2 class="heading-title-fq show-for-medium tac pt4rem">{{ __('FAQ_HEADLINE') }}</h2>
            @elseif (Route::current()->getName() == 'profile')
                <h2 class="heading-title-fq show-for-medium tac pt4rem">{{ __('FAQ_PROFILE_HEADLINE') }}</h2>
            @endif
            <br />
        </div>
        <div itemscope itemtype="https://schema.org/FAQPage">
            @for ($i = 0; $i < 6; $i++)
                @include('frontend.partials.components.accordion-item', ['i' => $i])
            @endfor
        </div>
        <p class="learn-btn text-center df aic jcc"><a class="btn mt32 fs18" href="{{ route('faq') }}"
                class="button large">{{ __('FAQ_BUTTON_VIEW_ALL') }}</a></p>
    </div>
</section>
