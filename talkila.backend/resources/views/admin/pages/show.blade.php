@extends('layout.mainlayout')
@section('content')
    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.page.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.cms.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.page.fields.id') }}
                                </th>
                                <td>
                                    {{ $pages->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.page.fields.title') }}
                                </th>
                                <td>
                                    {{ $pages->title ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.page.fields.slug') }}
                                </th>
                                <td>
                                    {{ $pages->slug }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.page.fields.body') }}
                                </th>
                                <td>

                                    {!! $pages->body !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.page.fields.meta_data') }}
                                </th>
                                <td>
                                    {{ $pages->meta_data ?? '' }}
                                </td>
                            <tr>
                                <th>
                                    {{ trans('cruds.page.fields.language') }}
                                </th>
                                <td>
                                    {{ \App\Models\StaticProfession::DATABASE_LANGUAGE[$pages->language] ?? '' }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.cms.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Data Table -->
@endsection
