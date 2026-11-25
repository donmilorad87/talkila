{!! Form::open(['route' => ['admin.blog.cms.destroy', $id], 'method' => 'delete']) !!}

    <div class="btn-group" role="group">

        @can( 'PageController@show' )

            <a href="{{ route('admin.blog.cms.show', $id) }}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showResourceModal" data-resource-id="{{ $id }}" data-resource-name="pages">
                <span data-toggle="tooltip" data-placement="top" title="Show"><i class="material-icons material-icon-smaller">visibility</i></span>
            </a>

        @endcan

        @can( 'PageController@edit' )

            <a href="{{ route('admin.blog.cms.edit', $id) }}" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                <i class="material-icons material-icon-smaller text-dark">mode_edit</i>
            </a>

        @endcan

        @can( 'PageController@destroy' )

            {!! Form::button('<i class="material-icons material-icon-smaller text-danger">remove_circle</i>', [
                'type' => 'submit',
                'class' => 'btn btn-outline-secondary btn-sm',
                'data-toggle' => 'tooltip',
                'data-placement' => 'top',
                'title' => 'Delete',
                'onclick' => "return confirm('Are you sure you want to delete this?')"
            ]) !!}

        @endcan

    </div>

{!! Form::close() !!}
