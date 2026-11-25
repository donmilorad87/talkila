@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.users.update', [$user->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.name_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.email_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="username">{{ trans('cruds.user.fields.username') }}</label>
                        <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required>
                        @if($errors->has('username'))
                            <div class="invalid-feedback">
                                {{ $errors->first('username') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.username_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.password_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="description">{{ trans('cruds.user.fields.about_me') }}</label>
                        <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $user->description) !!}</textarea>
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.about_me_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <div class="form-check {{ $errors->has('notification_message') ? 'is-invalid' : '' }}">
                            <input type="hidden" name="notification_message" value="0">
                            <input class="form-check-input" type="checkbox" name="notification_message" id="notification_message" value="1" {{ $user->notification_message || old('notification_message', 0) == 1 ? 'checked' : '' }}>
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
                        <label for="youtube_video">{{ trans('cruds.user.fields.youtube_video') }}</label>
                        <input class="form-control {{ $errors->has('youtube_video') ? 'is-invalid' : '' }}" type="text" name="youtube_video" id="youtube_video" value="{{ old('youtube_video', $user->youtube_video) }}">
                        @if($errors->has('youtube_video'))
                            <div class="invalid-feedback">
                                {{ $errors->first('youtube_video') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.youtube_video_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="visibility">{{ trans('cruds.user.fields.visibility.title') }}</label>
                        <select class="form-control {{ $errors->has('visibility') ? 'is-invalid' : '' }}" name="visibility" id="visibility">
                            <option value="0" {{ old('visibility') == 0 || $user->visibility == 0 ? 'selected' : '' }}>Visable</option>
                            <option value="1" {{ old('visibility') == 1 || $user->visibility == 1 ? 'selected' : '' }}>Open</option>
                            <option value="2" {{ old('visibility') == 2 || $user->visibility == 2 ? 'selected' : '' }}>Private</option>
                        </select>
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.visibility.title_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="billing_address_id">{{ trans('cruds.talk.fields.billing_address') }}</label>
                        <select class="form-control {{ $errors->has('billing_address') ? 'is-invalid' : '' }}" name="billing_address_id" id="billing_address_id">
                            @foreach($billing_addresses as $id => $billing_address)
                                <option
                                        value="{{ $billing_address->id }}"
                                        selected="{{ ($user->billing_address_id ? $user->billing_address_id : old('billing_address_id')) == $id ? 'selected' : '' }}"
                                >
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
                        <label class="required" for="state">{{ trans('cruds.user.fields.state.title') }}</label>
                        <select class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state" id="state">
{{--                            <option value="0" {{ $user->state == 0 ? 'selected' : '' }}>Account not activated</option>--}}
                            <option value="1" {{ $user->state == 1 ? 'selected' : '' }}> Approved</option>
                            <option value="3" {{ $user->state == 3 ? 'selected' : '' }}> Deactivated</option>
                            <option value="2" {{ $user->state == 2 ? 'selected' : '' }}> Spam</option>
                        </select>
                        @if($errors->has('state'))
                            <div class="invalid-feedback">
                                {{ $errors->first('state') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.user.fields.state.title_helper') }}</small>
                    </div>
                    <div class="form-group" id="deactivated-reason" style="{{ $user->state != 3 ? 'display:none' : '' }}">
                        <label class="required" for="reason">{{ trans('cruds.user.fields.reason') }}</label>
                        <div class="form-group">
                            <textarea class="form-control" rows="8" placeholder="Deactivation reason" name="deactivation_reason">{{ $user->deactivation_reason }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                            @foreach($roles as $id => $roles)
                                <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('roles'))
                            <div class="invalid-feedback">
                                {{ $errors->first('roles') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
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

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#state').change(function () {
                if($(this).val() === '3') {
                    $('#deactivated-reason').show();
                } else {
                    $('#deactivated-reason').hide();
                }
            });

        });
    </script>
@endsection
