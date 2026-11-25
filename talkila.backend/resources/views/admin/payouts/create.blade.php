@extends('layout.mainlayout')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('global.create') }} {{ trans('cruds.payout.title_singular') }}</h5>
                </div>

                <form method="POST" action="{{ route('admin.payout-invoices.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="payout_date">{{ trans('cruds.payout.fields.payout_date') }}</label>
                        <input class="form-control datetime {{ $errors->has('payout_date') ? 'is-invalid' : '' }}" type="text" name="payout_date" id="payout_date" value="{{ old('payout_date') }}">
                        @if($errors->has('payout_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('payout_date') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.payout.fields.payout_date_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="price">{{ trans('cruds.payout.fields.price') }}</label>
                        <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '') }}" step="0.01">
                        @if($errors->has('price'))
                            <div class="invalid-feedback">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.payout.fields.price_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label class="required" for="finance_currencies_id">{{ trans('cruds.payout.fields.finance_currencies') }}</label>
                        <select class="form-control {{ $errors->has('finance_currencies') ? 'is-invalid' : '' }}" name="finance_currencies_id" id="finance_currencies_id" required>
                            @foreach($finance_currencies as $id => $finance_currencies)
                                <option value="{{ $id }}" {{ old('finance_currencies_id') == $id ? 'selected' : '' }}>{{ $finance_currencies }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('finance_currencies'))
                            <div class="invalid-feedback">
                                {{ $errors->first('finance_currencies') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.payout.fields.finance_currencies_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="invoice_number">{{ trans('cruds.payout.fields.invoice_number') }}</label>
                        <input class="form-control {{ $errors->has('invoice_number') ? 'is-invalid' : '' }}" type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number', '') }}">
                        @if($errors->has('invoice_number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('invoice_number') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.payout.fields.invoice_number_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="sales_tax">{{ trans('cruds.payout.fields.sales_tax') }}</label>
                        <input class="form-control {{ $errors->has('sales_tax') ? 'is-invalid' : '' }}" type="number" name="sales_tax" id="sales_tax" value="{{ old('sales_tax', '') }}" step="1">
                        @if($errors->has('sales_tax'))
                            <div class="invalid-feedback">
                                {{ $errors->first('sales_tax') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.payout.fields.sales_tax_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="reference">{{ trans('cruds.payout.fields.reference') }}</label>
                        <input class="form-control {{ $errors->has('reference') ? 'is-invalid' : '' }}" type="text" name="reference" id="reference" value="{{ old('reference', '') }}">
                        @if($errors->has('reference'))
                            <div class="invalid-feedback">
                                {{ $errors->first('reference') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.payout.fields.reference_helper') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="transferred_date">{{ trans('cruds.payout.fields.transferred_date') }}</label>
                        <input class="form-control datetime {{ $errors->has('transferred_date') ? 'is-invalid' : '' }}" type="text" name="transferred_date" id="transferred_date" value="{{ old('transferred_date') }}">
                        @if($errors->has('transferred_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('transferred_date') }}
                            </div>
                        @endif
                        <small class="form-text text-muted">{{ trans('cruds.payout.fields.transferred_date_helper') }}</small>
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
