@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.billingAddress.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.billing-addresses.update', [$billingAddress->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="street">{{ trans('cruds.billingAddress.fields.street') }}</label>
                        <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text" name="street" id="street" value="{{ old('street', $billingAddress->street) }}">
                        @if($errors->has('street'))
                            <div class="invalid-feedback">
                                {{ $errors->first('street') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.billingAddress.fields.street_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="zipcode">{{ trans('cruds.billingAddress.fields.zipcode') }}</label>
                        <input class="form-control {{ $errors->has('zipcode') ? 'is-invalid' : '' }}" type="text" name="zipcode" id="zipcode" value="{{ old('zipcode', $billingAddress->zipcode) }}">
                        @if($errors->has('zipcode'))
                            <div class="invalid-feedback">
                                {{ $errors->first('zipcode') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.billingAddress.fields.zipcode_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="city">{{ trans('cruds.billingAddress.fields.city') }}</label>
                        <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $billingAddress->city) }}">
                        @if($errors->has('city'))
                            <div class="invalid-feedback">
                                {{ $errors->first('city') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.billingAddress.fields.city_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="company_name">{{ trans('cruds.billingAddress.fields.company_name') }}</label>
                        <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', $billingAddress->company_name) }}">
                        @if($errors->has('company_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('company_name') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.billingAddress.fields.company_name_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="tax_number">{{ trans('cruds.billingAddress.fields.tax_number') }}</label>
                        <input class="form-control {{ $errors->has('tax_number') ? 'is-invalid' : '' }}" type="text" name="tax_number" id="tax_number" value="{{ old('tax_number', $billingAddress->tax_number) }}">
                        @if($errors->has('tax_number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('tax_number') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.billingAddress.fields.tax_number_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="email">{{ trans('cruds.billingAddress.fields.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $billingAddress->email) }}">
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.billingAddress.fields.email_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="tel_number">{{ trans('cruds.billingAddress.fields.tel_number') }}</label>
                        <input class="form-control {{ $errors->has('tel_number') ? 'is-invalid' : '' }}" type="text" name="tel_number" id="tel_number" value="{{ old('tel_number', $billingAddress->tel_number) }}">
                        @if($errors->has('tel_number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('tel_number') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.billingAddress.fields.tel_number_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="countries_id">{{ trans('cruds.billingAddress.fields.countries') }}</label>
                        <select class="form-control {{ $errors->has('countries') ? 'is-invalid' : '' }}" name="countries_id" id="countries_id">
                            @foreach($countries as $id => $countries)
                                <option value="{{ $id }}" {{ ($billingAddress->countries ? $billingAddress->countries->id : old('countries_id')) == $id ? 'selected' : '' }}>{{ $countries }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('countries'))
                            <div class="invalid-feedback">
                                {{ $errors->first('countries') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.billingAddress.fields.countries_helper') }}</small>
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
