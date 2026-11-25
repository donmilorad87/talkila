@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.availability.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.availabilities.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">{{ trans('cruds.availability.fields.user') }}</label>
                        <select class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.availability.fields.user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="state">{{ trans('cruds.availability.fields.state') }}</label>
                        <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="number" name="state" id="state" value="{{ old('state', '') }}" step="1">
                        @if($errors->has('state'))
                            <div class="invalid-feedback">
                                {{ $errors->first('state') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.availability.fields.state_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="start_time">{{ trans('cruds.availability.fields.start_time') }}</label>
                        <input class="form-control {{ $errors->has('start_time') ? 'is-invalid' : '' }}" type="text" name="start_time" id="start_time" value="{{ old('start_time') }}">
                        @if($errors->has('start_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_time') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.availability.fields.start_time_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="end_time">{{ trans('cruds.availability.fields.end_time') }}</label>
                        <input class="form-control {{ $errors->has('end_time') ? 'is-invalid' : '' }}" type="text" name="end_time" id="end_time" value="{{ old('end_time') }}">
                        @if($errors->has('end_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_time') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.availability.fields.end_time_helper') }}</small>
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

@push('after-scripts')
    <script type="text/javascript">
        $('#start_time').datetimepicker({
            format: 'HH:mm',
            stepping: 15,
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right'
            }
        });

        $('#end_time').datetimepicker({
            format: 'HH:mm',
            stepping: 15,
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right'
            }
        });
    </script>
@endpush
