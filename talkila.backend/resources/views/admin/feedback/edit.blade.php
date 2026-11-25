@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.feedback.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.feedback.update', [$feedback->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="user_id">{{ trans('cruds.feedback.fields.participiant') }}</label>
                        <select class="form-control {{ $errors->has('participiant') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                            @foreach($participiants as $id => $participiant)
                                <option value="{{ $id }}" {{ ($feedback->participiant ? $feedback->participiant->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $participiant }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('participiant'))
                            <div class="invalid-feedback">
                                {{ $errors->first('participiant') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.feedback.fields.participiant_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="booking_id">{{ trans('cruds.feedback.fields.calls') }}</label>
                        <select class="form-control {{ $errors->has('calls') ? 'is-invalid' : '' }}" name="booking_id" id="booking_id">
                            @foreach($calls as $id => $calls)
                                <option value="{{ $id }}" {{ ($feedback->calls ? $feedback->calls->id : old('booking_id')) == $id ? 'selected' : '' }}>{{ $calls }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('calls'))
                            <div class="invalid-feedback">
                                {{ $errors->first('calls') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.feedback.fields.calls_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="stars_content">{{ trans('cruds.feedback.fields.stars_content') }}</label>
                        <input class="form-control {{ $errors->has('stars_content') ? 'is-invalid' : '' }}" type="number" name="stars_content" id="stars_content" value="{{ old('stars_content', $feedback->stars_content) }}" step="1">
                        @if($errors->has('stars_content'))
                            <div class="invalid-feedback">
                                {{ $errors->first('stars_content') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.feedback.fields.stars_content_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="stars_voice_quality">{{ trans('cruds.feedback.fields.stars_voice_quality') }}</label>
                        <input class="form-control {{ $errors->has('stars_voice_quality') ? 'is-invalid' : '' }}" type="text" name="stars_voice_quality" id="stars_voice_quality" value="{{ old('stars_voice_quality', $feedback->stars_voice_quality) }}">
                        @if($errors->has('stars_voice_quality'))
                            <div class="invalid-feedback">
                                {{ $errors->first('stars_voice_quality') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.feedback.fields.stars_voice_quality_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="description">{{ trans('cruds.feedback.fields.description') }}</label>
                        <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $feedback->description) !!}</textarea>
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.feedback.fields.description_helper') }}</small>
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
<small class="form-text text-muted">{{ trans('cruds.permission.fields.title_helper') }}</small>
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
                xhr.open('POST', '/admin/feedback/ckmedia', true);
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
                data.append('crud_id', {{ $feedback->id ?? 0 }});
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
