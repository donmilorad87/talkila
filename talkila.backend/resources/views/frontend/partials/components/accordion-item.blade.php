<div class="acCont" data-allow-multiple-open="0">

    <div class="ac" data-ac-open="0" data-number="{{ $i }}" itemscope itemprop="mainEntity"
        itemtype="https://schema.org/Question">
        <div class="df aic w-100 jcsb pr16">
            <h4 class="noselect" itemprop="name">
                {{ __('FAQ_QUESTION_HEADLINE_' . ($i + 1)) }}
            </h4>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 20" width="12" height="20">
                <path
                    d="M10.7045 9.32345C10.7045 9.78153 3.77439 17.7115 3.77439 17.7115C3.19605 18.3686 2.25738 18.3686 1.67793 17.7115C1.09849 17.0544 1.09849 15.99 1.67793 15.3328L6.84399 9.47568L1.50888 3.42696C0.907195 2.74318 0.907195 1.63695 1.50888 0.954439C2.11057 0.271927 3.08706 0.271927 3.68875 0.954439C3.68875 0.954439 10.7045 8.86537 10.7045 9.32345Z"
                    fill="#B9BFC9" />
            </svg>
        </div>

        <div class="acceptedAnswer" itemscope itemprop="acceptedAnswer"
            itemtype="https://schema.org/Answer">
            <p itemprop="text" class="pb16">
                {{ __('FAQ_ITEM_TEXT_' . ($i + 1)) }}
            </p>
        </div>
    </div>

</div>
