@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.staticMetric.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.static-metrics.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="user_id">{{ trans('cruds.staticMetric.fields.user') }}</label>
                        <select class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticMetric.fields.user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="follower">{{ trans('cruds.staticMetric.fields.follower') }}</label>
                        <input class="form-control {{ $errors->has('follower') ? 'is-invalid' : '' }}" type="number" name="follower" id="follower" value="{{ old('follower', '') }}" step="1">
                        @if($errors->has('follower'))
                            <div class="invalid-feedback">
                                {{ $errors->first('follower') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticMetric.fields.follower_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="reviews">{{ trans('cruds.staticMetric.fields.reviews') }}</label>
                        <input class="form-control {{ $errors->has('reviews') ? 'is-invalid' : '' }}" type="number" name="reviews" id="reviews" value="{{ old('reviews', '') }}" step="1">
                        @if($errors->has('reviews'))
                            <div class="invalid-feedback">
                                {{ $errors->first('reviews') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticMetric.fields.reviews_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="talks">{{ trans('cruds.staticMetric.fields.talks') }}</label>
                        <input class="form-control {{ $errors->has('talks') ? 'is-invalid' : '' }}" type="number" name="talks" id="talks" value="{{ old('talks', '') }}" step="1">
                        @if($errors->has('talks'))
                            <div class="invalid-feedback">
                                {{ $errors->first('talks') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticMetric.fields.talks_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="revenue">{{ trans('cruds.staticMetric.fields.revenue') }}</label>
                        <input class="form-control {{ $errors->has('revenue') ? 'is-invalid' : '' }}" type="number" name="revenue" id="revenue" value="{{ old('revenue', '') }}" step="1">
                        @if($errors->has('revenue'))
                            <div class="invalid-feedback">
                                {{ $errors->first('revenue') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticMetric.fields.revenue_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="bad_reports">{{ trans('cruds.staticMetric.fields.bad_reports') }}</label>
                        <input class="form-control {{ $errors->has('bad_reports') ? 'is-invalid' : '' }}" type="number" name="bad_reports" id="bad_reports" value="{{ old('bad_reports', '') }}" step="1">
                        @if($errors->has('bad_reports'))
                            <div class="invalid-feedback">
                                {{ $errors->first('bad_reports') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticMetric.fields.bad_reports_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="send_emails">{{ trans('cruds.staticMetric.fields.send_emails') }}</label>
                        <input class="form-control {{ $errors->has('send_emails') ? 'is-invalid' : '' }}" type="number" name="send_emails" id="send_emails" value="{{ old('send_emails', '') }}" step="1">
                        @if($errors->has('send_emails'))
                            <div class="invalid-feedback">
                                {{ $errors->first('send_emails') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticMetric.fields.send_emails_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="searches_per_day">{{ trans('cruds.staticMetric.fields.searches_per_day') }}</label>
                        <input class="form-control {{ $errors->has('searches_per_day') ? 'is-invalid' : '' }}" type="number" name="searches_per_day" id="searches_per_day" value="{{ old('searches_per_day', '') }}" step="1">
                        @if($errors->has('searches_per_day'))
                            <div class="invalid-feedback">
                                {{ $errors->first('searches_per_day') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticMetric.fields.searches_per_day_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="visited_user_profils_per_day">{{ trans('cruds.staticMetric.fields.visited_user_profils_per_day') }}</label>
                        <input class="form-control {{ $errors->has('visited_user_profils_per_day') ? 'is-invalid' : '' }}" type="number" name="visited_user_profils_per_day" id="visited_user_profils_per_day" value="{{ old('visited_user_profils_per_day', '') }}" step="1">
                        @if($errors->has('visited_user_profils_per_day'))
                            <div class="invalid-feedback">
                                {{ $errors->first('visited_user_profils_per_day') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticMetric.fields.visited_user_profils_per_day_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="dont_show_again">{{ trans('cruds.staticMetric.fields.dont_show_again') }}</label>
                        <input class="form-control {{ $errors->has('dont_show_again') ? 'is-invalid' : '' }}" type="number" name="dont_show_again" id="dont_show_again" value="{{ old('dont_show_again', '') }}" step="1">
                        @if($errors->has('dont_show_again'))
                            <div class="invalid-feedback">
                                {{ $errors->first('dont_show_again') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticMetric.fields.dont_show_again_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="visited">{{ trans('cruds.staticMetric.fields.visited') }}</label>
                        <input class="form-control {{ $errors->has('visited') ? 'is-invalid' : '' }}" type="number" name="visited" id="visited" value="{{ old('visited', '') }}" step="1">
                        @if($errors->has('visited'))
                            <div class="invalid-feedback">
                                {{ $errors->first('visited') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.staticMetric.fields.visited_helper') }}</small>
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
