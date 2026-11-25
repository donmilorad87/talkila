@extends('layout.mainlayout')

@section('content')
	<div class="row">
		<div class="col-xl-12">
			<div class="card mb-30">
				<div class="card-body">
					<div class="card-header">
						<h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.page.title_singular') }}</h5>
					</div>

						<form method="POST" action="{{ route('admin.cms.update', [$pages->id]) }}" enctype="multipart/form-data">
						@method('PUT')
						@csrf

						<div class="form-group">
							<label class="required" for="title">{{ trans('cruds.page.fields.title') }}</label>
							<input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $pages->title) }}" required>
							@if($errors->has('title'))
								<div class="invalid-feedback">
									{{ $errors->first('title') }}
								</div>
							@endif
							<small class="form-text text-muted">{{ trans('cruds.page.fields.title_helper') }}</small>
						</div>

						<div class="form-group">
							<label class="required" for="slug">{{ trans('cruds.page.fields.slug') }}</label>
							<input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $pages->slug) }}" required>
							@if($errors->has('slug'))
								<div class="invalid-feedback">
									{{ $errors->first('slug') }}
								</div>
							@endif
							<small class="form-text text-muted">{{ trans('cruds.page.fields.slug_helper') }}</small>
						</div>

						<div class="form-group">
							<label class="required" for="body">{{ trans('cruds.page.fields.body') }}</label>
							<textarea  class="{{ $errors->has('body') ? 'is-invalid' : '' }}" id="post_content" name="body" value="{{ old('body', '') }}">{!! old('body', $pages->body) !!}</textarea>
			                <script>
			                        CKEDITOR.replace( 'body' );
			                </script>
							@if($errors->has('body'))
								<div class="invalid-feedback">
									{{ $errors->first('body') }}
								</div>
							@endif
							<small class="form-text text-muted">{{ trans('cruds.page.fields.body_helper') }}</small>
						</div>

						<div class="form-group">
							<label class="required" for="meta_data">{{ trans('cruds.page.fields.meta_data') }}</label>
							<input class="form-control {{ $errors->has('meta_data') ? 'is-invalid' : '' }}" type="text" name="meta_data" id="meta_data" value="{{ old('meta_data', $pages->meta_data) }}" required>
							@if($errors->has('meta_data'))
								<div class="invalid-feedback">
									{{ $errors->first('meta_data') }}
								</div>
							@endif
							<small class="form-text text-muted">{{ trans('cruds.page.fields.meta_data_helper') }}</small>
						</div>

							<div class="form-group">
								<label class="required" for="language">{{ trans('cruds.page.fields.language') }}</label>
								<select class="form-control {{ $errors->has('language') ? 'is-invalid' : '' }}" name="language" id="language" required>
									<option value="en" {{ $pages->language == 'en' ? 'selected' : '' }}>English</option>
									<option value="hr" {{ $pages->language == 'hr' ? 'selected' : '' }}>Croatian</option>
									<option value="de" {{ $pages->language == 'de' ? 'selected' : '' }}>German</option>
                                    <option value="pl" {{ $pages->language == 'pl' ? 'selected' : '' }}>Polish</option>
								</select>
								@if($errors->has('language'))
									<div class="invalid-feedback">
										{{ $errors->first('language') }}
									</div>
								@endif
								<small class="form-text text-muted">{{ trans('cruds.page.fields.language') }}</small>
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

@section('footer_scripts')
	<script src="{{asset('/assets/js/tinymce/jquery.tinymce.min.js')}}"></script>
	<script src="{{asset('/assets/js/tinymce/tinymce.min.js')}}"></script>

    <script>
		var editor_config = {
			path_absolute : "/",
			selector: "textarea.editor",
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern codesample",
				"toc imagetools help"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic strikethrough | alignleft aligncenter alignright alignjustify | ltr rtl | bullist numlist outdent indent removeformat formatselect| link image media | emoticons charmap | code codesample | forecolor backcolor",

			browser_spellcheck: true,
			relative_urls: false,
			remove_script_host: false,
			file_browser_callback : function(field_name, url, type, win) {

				var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
				var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

				var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;

				if (type == 'image') {
					cmsURL = cmsURL + "&type=Images";
				} else {
					cmsURL = cmsURL + "&type=Files";
				}
				tinyMCE.activeEditor.windowManager.open({
					file : cmsURL,
					title : 'Filemanager',
					width : x * 0.8,
					height : y * 0.8,
					resizable : "yes",
					close_previous : "no"
				});
			},
			setup: function (editor) {
				editor.on('change', function () {
					editor.save();
				});
			}
		};

		tinymce.init(editor_config);
    </script>
@endsection
