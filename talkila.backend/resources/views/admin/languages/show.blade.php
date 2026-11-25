@extends('layout.mainlayout')
@section('content')

    <!-- Data Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.show') }} {{ trans('cruds.language.title') }}</h5>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.languages.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.language.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $language->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.language.fields.code') }}
                                    </th>
                                    <td>
                                        {{ $language->code }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.language.fields.order_by') }}
                                    </th>
                                    <td>
                                        {{ $language->order_by }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.language.fields.croatian') }}
                                    </th>
                                    <td>
                                        {{ $language->croatian }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.language.fields.english') }}
                                    </th>
                                    <td>
                                        {{ $language->english }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.language.fields.german') }}
                                    </th>
                                    <td>
                                        {{ $language->german }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.languages.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Data Table -->
    <div class="card-body">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#language_languages_profils" role="tab" data-toggle="tab">
                    {{ trans('cruds.languagesProfil.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#language_autocomplete_tags" role="tab" data-toggle="tab">
                    {{ trans('cruds.autocompleteTag.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#languages_talks" role="tab" data-toggle="tab">
                    {{ trans('cruds.talk.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="language_languages_profils">
                @includeIf('admin.languages.relationships.languageLanguagesProfils', ['languagesProfils' => $language->languageLanguagesProfils])
            </div>
            <div class="tab-pane" role="tabpanel" id="languages_talks">
                @includeIf('admin.languages.relationships.languagesTalks', ['talks' => $language->languagesTalks])
            </div>
        </div>
    </div>
@endsection
