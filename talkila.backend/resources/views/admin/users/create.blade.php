@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.name_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.email_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="username">{{ trans('cruds.user.fields.username') }}</label>
                        <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="username" name="username" id="username" value="{{ old('username') }}" required>
                        @if($errors->has('username'))
                            <div class="invalid-feedback">
                                {{ $errors->first('username') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.username_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.password_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="gender">{{ trans('cruds.user.fields.gender.title') }}</label>
                        <select class="form-control select2 {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender">
                            <option value="0" {{ old('gender') == 0 ? 'selected' : '' }} selected>{{ trans('cruds.user.fields.gender.undefined') }}</option>
                            <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>{{ trans('cruds.user.fields.gender.male') }}</option>
                            <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>{{ trans('cruds.user.fields.gender.female') }}</option>
                        </select>
                        @if($errors->has('gender'))
                            <div class="invalid-feedback">
                                {{ $errors->first('gender') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.gender.title_helper') }}</small>
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
                        <label for="profession">{{ trans('cruds.user.fields.profession') }}</label>
                        <input class="form-control {{ $errors->has('profession') ? 'is-invalid' : '' }}" type="text" name="profession" id="profession" value="{{ old('profession', '') }}">
                        @if($errors->has('profession'))
                            <div class="invalid-feedback">
                                {{ $errors->first('profession') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.profession_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="youtube_video">{{ trans('cruds.user.fields.youtube_video') }}</label>
                        <input class="form-control {{ $errors->has('youtube_video') ? 'is-invalid' : '' }}" type="text" name="youtube_video" id="youtube_video" value="{{ old('youtube_video', '') }}">
                        @if($errors->has('youtube_video'))
                            <div class="invalid-feedback">
                                {{ $errors->first('youtube_video') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.youtube_video_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <div class="form-check {{ $errors->has('notification_message') ? 'is-invalid' : '' }}">
                            <input type="hidden" name="notification_message" value="0">
                            <input class="form-check-input" type="checkbox" name="notification_message" id="notification_message" value="1" {{ old('notification_message', 0) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="notification_message">{{ trans('cruds.user.fields.notification_message') }}</label>
                        </div>
                        @if($errors->has('notification_message'))
                            <div class="invalid-feedback">
                                {{ $errors->first('notification_message') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.notification_message_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="notification_sound">{{ trans('cruds.user.fields.notification_sound') }}</label>
                        <select class="form-control {{ $errors->has('notification_sound') ? 'is-invalid' : '' }}" name="notification_sound" id="notification_sound">
                            <option value="1" {{ old('notification_sound') == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('notification_sound') == 2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('notification_sound') == 3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ old('notification_sound') == 4 ? 'selected' : '' }}>4</option>
                            <option value="5" {{ old('notification_sound') == 5 ? 'selected' : '' }}>5</option>
                            <option value="6" {{ old('notification_sound') == 6 ? 'selected' : '' }}>6</option>
                            <option value="7" {{ old('notification_sound') == 7 ? 'selected' : '' }}>7</option>
                            <option value="8" {{ old('notification_sound') == 8 ? 'selected' : '' }}>8</option>
                            <option value="9" {{ old('notification_sound') == 9 ? 'selected' : '' }}>9</option>
                        </select>
                        @if($errors->has('notification_sound'))
                            <div class="invalid-feedback">
                                {{ $errors->first('notification_sound') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.notification_sound_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="visibility">{{ trans('cruds.user.fields.visibility.title') }}</label>
                        <div class="form-check">
                            <input type="hidden" name="visibility" value="0">
                            <input class="form-check-input" type="radio" name="visibility" id="visibility" value="1" {{ old('visibility', 0) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="visibility">{{ trans('cruds.user.fields.visibility.open') }}</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="visibility" value="0">
                            <input class="form-check-input" type="radio" name="visibility" id="visibility_private" value="2" {{ old('visibility', 0) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="visibility_private">{{ trans('cruds.user.fields.visibility.private') }}</label>
                        </div>

                        <small class="form-text text-muted">{{ trans('cruds.user.fields.approved_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="billing_address_id">{{ trans('cruds.talk.fields.billing_address') }}</label>
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
                        <label class="required" for="state">{{ trans('cruds.user.fields.state.title') }}</label>
                        <select class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state" id="state">
                            {{--                            <option value="0" {{ $user->state == 0 ? 'selected' : '' }}>Account not activated</option>--}}
                            <option value="1"> Approved</option>
                            <option value="3"> Deactivated</option>
                            <option value="2"> Spam</option>
                        </select>
                        @if($errors->has('state'))
                            <div class="invalid-feedback">
                                {{ $errors->first('state') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.state.title_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                            @foreach($roles as $id => $role)
                                <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('roles'))
                            <div class="invalid-feedback">
                                {{ $errors->first('roles') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.roles_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" for="profile_picture">{{ trans('cruds.user.fields.profile_picture') }}</label>
                        <div class="form-check {{ $errors->has('profile_picture') ? 'is-invalid' : '' }}">
                            <input class="form-control-file" type="file" name="profile_picture" id="profile_picture" {{ old('profile_picture', 0) == 1 ? 'checked' : '' }}>
                        </div>
                        @if($errors->has('profile_picture'))
                            <div class="invalid-feedback">
                                {{ $errors->first('profile_picture') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.approved_helper') }}</small>
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

{{--<script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete&language=nl&output=json&key=YOUR_GOOGLE_MAPS_KEY" async defer></script>--}}

{{--<script type="text/javascript">--}}
{{--  function initAutocomplete() {--}}
{{--    var location = document.getElementById('location');--}}
{{--    var autocomplete = new google.maps.places.Autocomplete(location);--}}
{{--  }--}}
{{--</script>--}}

@endsection
