<div class="row">

    <div class="col-sm-6">

        <p class="font-weight-bold mb-0">
            Id:
        </p>

        <p>
            {!! $pages->id !!}
        </p>

        <hr>

    </div>

    <div class="col-sm-6">

        <p class="font-weight-bold mb-0">
            Title:
        </p>

        <p>
            {!! $pages->title !!}
        </p>

        <hr>

    </div>

    <div class="col-sm-6">

        <p class="font-weight-bold mb-0">
            Slug:
        </p>

        <p>
            {!! $pages->slug !!}
        </p>

        <hr>

    </div>

    <div class="col-sm-6">

        <p class="font-weight-bold mb-0">
            Body:
        </p>

        <p>
            {!! $pages->body !!}
        </p>

        <hr>

    </div>

    <div class="col-sm-6">

        <p class="font-weight-bold mb-0">
            Meta-Data:
        </p>

        <p>
            {!! $pages->meta_data !!}
        </p>

        <hr>

    </div>

    <div class="col-sm-6">

        <p class="font-weight-bold mb-0">
            Language:
        </p>

        <p>
            {!! \App\Models\StaticProfession::DATABASE_LANGUAGE[$pages->language] !!}
        </p>

        <hr>

    </div>

    <div class="col-sm-6">

        <p class="font-weight-bold mb-0">
            Created At:
        </p>

        <p>
            {!! $pages->created_at !!}
        </p>

        <hr>

    </div>

    <div class="col-sm-6">

        <p class="font-weight-bold mb-0">
            Updated At:
        </p>

        <p>
            {!! $pages->updated_at !!}
        </p>

        <hr>

    </div>

</div>
