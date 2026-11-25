@extends('frontend.layouts.frontendlayout')
@section('content')





    <div class="container accounts-content white-box pt4rem">


        <h1 class="page-title text-center">{!! $content['title'] ?? __('NOT_FOUND') !!}</h1>
        <div class="container">
            <div class="grid-x">
                @if (!empty($content['links']))
                    <div class="medium-4">
                        <ul class="tabs" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true"
                            data-deep-link-smudge-delay="500" data-tabs id="example-tabs">
                            @foreach ($content['links'] as $link)
                                <li
                                    class="tabs-title {{ ($content['page']['slug'] ?? '') == $link['slug'] ? 'is-active' : '' }}">
                                    <a href="/legal/{{ $link['slug'] }}"
                                        {{ ($content['page']['slug'] ?? '') == $link['slug'] ? 'aria-selected="true"' : '' }}>{{ $link['title'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="cell medium-12">


                    <div class="is-active" id="basic-account-information">
                        {!! $content['body'] ?? '' !!}
                    </div>


                </div>
            </div>
        </div>


    </div>




@endsection
