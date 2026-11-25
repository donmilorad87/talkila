<div class="dn">

    <div id="beurl">{{config('app.appBackendServerUrl')}}</div>
    <div id="socketServerUrl">{{config('app.appSocketServerUrl')}}</div>
    <div id="socketServerUrlShort">{{config('app.appSocketServerUrlShort')}}</div>
    <div id="app_version">{{config('app.version')}}</div>

    <div id="default_category_sub_category_show_items">{{config('app.default_category_sub_category_show_items')}}</div>
    <input type="hidden" id="default_favorites_show_more_users" value="{{config('app.default_favorites_show_more_users')}}"/>
    <input type="hidden" id="default_favorites_show_more_talks" value="{{config('app.default_favorites_show_more_talks')}}"/>
    <input type="hidden" id="show_more_talks" value="{{config('app.show_more_talks')}}"/>
    <div id="default_profile_talks_show_more">{{config('app.default_profile_talks_show_more')}}</div>
    <input type="hidden" id="default_notifications_count_show_more" value="{{config('app.default_notifications_count_show_more')}}" />
    <input type="hidden" id="spck" value="{{config('app.stripe_key')}}" />
    <input type="hidden" id="ppbpci" value="{{config('app.paypal_client_id')}}" />
    <input type="hidden" id="ppenv" value="{{config('app.paypal_environment')}}" />
    <input type="hidden" id="feurl" value="{{config('app.frontend_url')}}"/>
    <input type="hidden" id="app_environment" value="{{config('app.env')}}"/>
    <input type="hidden" id="socketServerPort" value="{{config('app.socket_server_port')}}"/>
    <input type="hidden" id="pusherAppKey" value="{{config('broadcasting.connections.pusher.key')}}"/>
    <input type="hidden" id="pusherAppCluster" value="{{config('broadcasting.connections.pusher.options.cluster')}}"/>
    <input type="hidden" id="app_talk_categories_version" value="{{config('app.app_talk_categories_version')}}"  />
    <input type="hidden" id="app_flags_version" value="{{config('app.app_flags_version')}}"  />
    <input type="hidden" id="app_languages_version" value="{{config('app.app_languages_version')}}"  />
    @auth
        <div id="userIsLogged"></div>
    @endauth

    @include('frontend.partials.components.flags-list')
    @include('frontend.partials.components.localization')

</div>
