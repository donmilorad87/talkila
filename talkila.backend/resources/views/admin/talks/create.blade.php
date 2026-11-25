@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.talk.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.talks.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="teacher_user_id">{{ trans('cruds.talk.fields.teacher_user') }}</label>
                        <select class="form-control {{ $errors->has('teacher_user') ? 'is-invalid' : '' }}" name="teacher_user_id" id="teacher_user_id">
                            @foreach($teacher_users as $id => $teacher_user)
                                <option value="{{ $id }}" {{ old('teacher_user_id') == $id ? 'selected' : '' }}>{{ $teacher_user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('teacher_user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('teacher_user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.talk.fields.teacher_user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="languages_id">{{ trans('cruds.talk.fields.languages') }}</label>
                        <select class="form-control {{ $errors->has('languages') ? 'is-invalid' : '' }}" name="languages_id" id="languages_id">
                            @foreach($languages as $id => $languages)
                                <option value="{{ $id }}" {{ old('languages_id') == $id ? 'selected' : '' }}>{{ $languages }}</option>
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
                            <option value="1" {{ old('anonym_call') == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('anonym_call') == 2 ? 'selected' : '' }}>2</option>
                        </select>
                        @if($errors->has('anonym_call'))
                            <div class="invalid-feedback">
                                {{ $errors->first('anonym_call') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.talk.fields.anonym_call_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="call_type">{{ trans('cruds.talk.fields.call_type') }}</label>
                        <select class="form-control {{ $errors->has('call_type') ? 'is-invalid' : '' }}" name="call_type" id="call_type">
                            <option value="1" {{ old('call_type') == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('call_type') == 2 ? 'selected' : '' }}>2</option>
                        </select>
                        @if($errors->has('call_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('call_type') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.talk.fields.call_type_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="talk_type">{{ trans('cruds.talk.fields.talk_type') }}</label>
                        <select class="form-control {{ $errors->has('talk_type') ? 'is-invalid' : '' }}" name="talk_type" id="talk_type">
                            <option value="1" {{ old('talk_type') == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('talk_type') == 2 ? 'selected' : '' }}>2</option>
                        </select>
                        @if($errors->has('talk_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('talk_type') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.talk.fields.talk_type_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="headline">{{ trans('cruds.talk.fields.headline') }}</label>
                        <input class="form-control {{ $errors->has('headline') ? 'is-invalid' : '' }}" type="text" name="headline" id="headline" value="{{ old('headline', '') }}">
                        @if($errors->has('headline'))
                            <div class="invalid-feedback">
                                {{ $errors->first('headline') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.talk.fields.headline_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="description">{{ trans('cruds.talk.fields.description') }}</label>
                        <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description') !!}</textarea>
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.talk.fields.description_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="duration">{{ trans('cruds.talk.fields.duration') }}</label>
                        <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="number" name="duration" id="duration" value="{{ old('duration', '') }}" min="5" max="600">
                        @if($errors->has('duration'))
                            <div class="invalid-feedback">
                                {{ $errors->first('duration') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.talk.fields.duration_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="price">{{ trans('cruds.talk.fields.price') }}</label>
                        <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '') }}">
                        @if($errors->has('price'))
                            <div class="invalid-feedback">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.talk.fields.price_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="max_participiants">{{ trans('cruds.talk.fields.max_participiants') }}</label>
                        <input class="form-control {{ $errors->has('max_participiants') ? 'is-invalid' : '' }}" type="number" name="max_participiants" id="max_participiants" value="{{ old('max_participiants', '1') }}" step="1">
                        @if($errors->has('max_participiants'))
                            <div class="invalid-feedback">
                                {{ $errors->first('max_participiants') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.talk.fields.max_participiants_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="finance_currencies_id">{{ trans('cruds.talk.fields.finance_currencies') }}</label>
                        <select class="form-control {{ $errors->has('finance_currencies') ? 'is-invalid' : '' }}" name="finance_currencies_id" id="finance_currencies_id">
                            @foreach($finance_currencies as $id => $finance_currencies)
                                <option value="{{ $id }}" {{ old('finance_currencies_id') == $id ? 'selected' : '' }}>{{ $finance_currencies }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('finance_currencies'))
                            <div class="invalid-feedback">
                                {{ $errors->first('finance_currencies') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.talk.fields.finance_currencies_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="billing_address_id">{{ trans('cruds.talk.fields.billing_address') }}</label>
                        <select class="form-control {{ $errors->has('billing_address') ? 'is-invalid' : '' }}" name="billing_address_id" id="billing_address_id">
                            @foreach($billing_addresses as $id => $billing_address)
                                <option value="{{ $id }}" {{ old('billing_address_id') == $id ? 'selected' : '' }}>{{ $billing_address }}</option>
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
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/admin/talks/ckmedia', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', {{ $talk->id ?? 0 }});
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection
