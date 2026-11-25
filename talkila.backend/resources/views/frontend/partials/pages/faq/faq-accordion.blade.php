<section>
    <h1 class="page-title text-center">{{ __('FAQ_PAGE_HEADLINE') }}</h1>
    <div itemscope itemtype="https://schema.org/FAQPage">
        @for ($i = 0; $i < 11; $i++)
            @include('frontend.partials.components.accordion-item', ['i' => $i])
        @endfor
    </div>


</section>
