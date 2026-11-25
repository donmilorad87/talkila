@extends('layout.mainlayout')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.payoutCurrency.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.payout-currencies.update', [$payoutCurrency->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="iso_code">{{ trans('cruds.payoutCurrency.fields.iso_code') }}</label>
                        <input class="form-control {{ $errors->has('iso_code') ? 'is-invalid' : '' }}" type="text" name="iso_code" id="iso_code" value="{{ old('iso_code', $payoutCurrency->iso_code) }}">
                        @if($errors->has('iso_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('iso_code') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.payoutCurrency.fields.iso_code_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="short_code">{{ trans('cruds.payoutCurrency.fields.short_code') }}</label>
                        <input class="form-control {{ $errors->has('short_code') ? 'is-invalid' : '' }}" type="text" name="short_code" id="short_code" value="{{ old('short_code', $payoutCurrency->short_code) }}">
                        @if($errors->has('short_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('short_code') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.payoutCurrency.fields.short_code_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="name">{{ trans('cruds.payoutCurrency.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $payoutCurrency->name) }}">
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.payoutCurrency.fields.name_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="value">{{ trans('cruds.payoutCurrency.fields.value') }}</label>
                        <input class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" type="text" name="value" id="value" value="{{ old('value', $payoutCurrency->value) }}">
                        @if($errors->has('value'))
                            <div class="invalid-feedback">
                                {{ $errors->first('value') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.payoutCurrency.fields.value_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="symbol">{{ trans('cruds.payoutCurrency.fields.symbol') }}</label>
                        <input class="form-control {{ $errors->has('symbol') ? 'is-invalid' : '' }}" type="text" name="symbol" id="symbol" value="{{ old('symbol', $payoutCurrency->symbol) }}">
                        @if($errors->has('symbol'))
                            <div class="invalid-feedback">
                                {{ $errors->first('symbol') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.payoutCurrency.fields.symbol_helper') }}</small>
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
