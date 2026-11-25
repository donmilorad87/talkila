@extends('layout.mainlayout')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.talk.title_singular') }}</h5>
                    </div>
                    <form method="POST" action="{{ route('admin.talks.update', [$talk->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="languages_id">{{ trans('cruds.talk.fields.languages') }}</label>
                            <select class="form-control {{ $errors->has('languages') ? 'is-invalid' : '' }}" name="languages_id" id="languages_id">
                                @foreach($languages as $id => $language)
                                    <option value="{{ $id }}"
                                            {{ $talk->language->id == $id ? 'selected' : '' }}
                                    >
                                        {{ $language }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('languages'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('languages') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.talk.fields.languages_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="anonym_call">{{ trans('cruds.talk.fields.anonym_call') }}</label>
                            <select class="form-control {{ $errors->has('anonym_call') ? 'is-invalid' : '' }}" name="anonym_call" id="anonym_call">
                                <option value="0" {{ ($talk->anonym_call ?: old('anonym_call')) == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($talk->anonym_call ?: old('anonym_call')) == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                            @if($errors->has('anonym_call'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('anonym_call') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.talk.fields.anonym_call_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="talk_type">{{ trans('cruds.talk.fields.talk_type') }}</label>
                            <select class="form-control {{ $errors->has('talk_type') ? 'is-invalid' : '' }}" name="talk_type" id="talk_type">
                                <option value="1" {{ (old('talk_type') ?: $talk->talk_type) == \App\Entity\TalkTypes::VOICE_CALL ? 'selected' : '' }}>Voice</option>
                                <option value="2" {{ (old('talk_type') ?: $talk->talk_type) == \App\Entity\TalkTypes::VIDEO_CALL ? 'selected' : '' }}>Video</option>
                            </select>
                            @if($errors->has('talk_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('talk_type') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.talk.fields.talk_type_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="talk_type">{{ trans('cruds.talk.fields.interactive_mode') }}</label>
                            <select class="form-control {{ $errors->has('interactive_mode') ? 'is-invalid' : '' }}" name="interactive_mode" id="interactive_mode">
                                <option value="1" {{ (old('interactive_mode') ?: $talk->interactive_mode) == \App\Entity\ModeTypes::WATCH ? 'selected' : '' }}>Watch Mode</option>
                                <option value="2" {{ (old('interactive_mode') ?: $talk->interactive_mode) == \App\Entity\ModeTypes::INTERACTIVE_ALL ? 'selected' : '' }}>Interactive Mode All</option>
                                <option value="3" {{ (old('interactive_mode') ?: $talk->interactive_mode) == \App\Entity\ModeTypes::INTERACTIVE_SINGLE ? 'selected' : '' }}>Interactive Mode Single</option>
                            </select>
                            @if($errors->has('interactive_mode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('interactive_mode') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.talk.fields.interactive_mode_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="headline">{{ trans('cruds.talk.fields.headline') }}</label>
                            <input class="form-control {{ $errors->has('headline') ? 'is-invalid' : '' }}" type="text" name="headline" id="headline" value="{{ old('headline', $talk->headline) }}">
                            @if($errors->has('headline'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('headline') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.talk.fields.headline_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ trans('cruds.talk.fields.description') }}</label>
                            <textarea style="" class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $talk->description) !!}</textarea>
                            @if($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.talk.fields.description_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="duration">{{ trans('cruds.talk.fields.duration') }}</label>
                            <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="number" name="duration" id="duration" value="{{ old('duration', $talk->duration) }}" step="1" min="5" max="600">
                            @if($errors->has('duration'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('duration') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.talk.fields.duration_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="price">{{ trans('cruds.talk.fields.price') }}</label>
                            <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $talk->price) }}" step="0.01">
                            @if($errors->has('price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('price') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.talk.fields.price_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="billing_address_id">{{ trans('cruds.talk.fields.billing_address') }}</label>
                            <select class="form-control {{ $errors->has('billing_address') ? 'is-invalid' : '' }}" name="billing_address_id" id="billing_address_id">
                                @foreach($billing_addresses as $billing_address)
                                    <option value="{{ $billing_address->id }}" {{ ($talk->billing_address ? $talk->billing_address->id : old('billing_address_id')) == $id ? 'selected' : '' }}>
                                        {{ "$billing_address->name - $billing_address->street - $billing_address->zip - $billing_address->city" }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('billing_address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('billing_address') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">{{ trans('cruds.talk.fields.billing_address_helper') }}</small>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
                    return {
                        upload: function () {
                            return loader.file.then(function (file) {
                                return new Promise(function (resolve, reject) {
                                    // Init request
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', '/admin/talks/ckmedia', true);
                                    xhr.setRequestHeader('x-csrf-token', window._token);
                                    xhr.setRequestHeader('Accept', 'application/json');
                                    xhr.responseType = 'json';

                                    // Init listeners
                                    var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                                    xhr.addEventListener('error', function () { reject(genericErrorText); });
                                    xhr.addEventListener('abort', function () { reject(); });
                                    xhr.addEventListener('load', function () {
                                        var response = xhr.response;

                                        if (! response || xhr.status !== 201) {
                                            return reject(response && response.message ? `${ genericErrorText }\n${ xhr.status } ${ response.message }` : `${ genericErrorText }\n ${ xhr.status } ${ xhr.statusText }`);
                                        }

                                        $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                        resolve({ default: response.url });
                                    });

                                    if (xhr.upload) {
                                        xhr.upload.addEventListener('progress', function (e) {
                                            if (e.lengthComputable) {
                                                loader.uploadTotal = e.total;
                                                loader.uploaded    = e.loaded;
                                            }
                                        });
                                    }

                                    // Send request
                                    var data = new FormData();
                                    data.append('upload', file);
                                    data.append('crud_id', {{ $talk->id ?? 0 }});
                                    xhr.send(data);
                                });
                            });
                        },
                    };
                };
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter],
                    },
                );
            }
        });
    </script>

@endsection
