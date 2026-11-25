@foreach ($talks as $talk)
    @include('frontend.partials.pages.courses.paginate_new_talks', ['talk' => $talk])
@endforeach
