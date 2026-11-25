@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.profilPayoutMethod.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.profile-payout-methods.update', [$profilPayoutMethod->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="user_id">{{ trans('cruds.profilPayoutMethod.fields.user') }}</label>
                        <select class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                            @foreach($users as $id => $user)
                                <option value="{{ $id }}" {{ ($profilPayoutMethod->user ? $profilPayoutMethod->user->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('user'))
                            <div class="invalid-feedback">
                                {{ $errors->first('user') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.profilPayoutMethod.fields.user_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="method">{{ trans('cruds.profilPayoutMethod.fields.method') }}</label>
                        <input class="form-control {{ $errors->has('method') ? 'is-invalid' : '' }}" type="number" name="method" id="method" value="{{ old('method', $profilPayoutMethod->method) }}" step="1">
                        @if($errors->has('method'))
                            <div class="invalid-feedback">
                                {{ $errors->first('method') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.profilPayoutMethod.fields.method_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="value">{{ trans('cruds.profilPayoutMethod.fields.value') }}</label>
                        <input class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" type="text" name="value" id="value" value="{{ old('value', $profilPayoutMethod->value) }}">
                        @if($errors->has('value'))
                            <div class="invalid-feedback">
                                {{ $errors->first('value') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.profilPayoutMethod.fields.value_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="state">{{ trans('cruds.profilPayoutMethod.fields.state') }}</label>
                        <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="number" name="state" id="state" value="{{ old('state', $profilPayoutMethod->state) }}" step="1">
                        @if($errors->has('state'))
                            <div class="invalid-feedback">
                                {{ $errors->first('state') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.profilPayoutMethod.fields.state_helper') }}</small>
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