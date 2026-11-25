@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="error-content">
        <div class="d-table">
            <div class="d-tablecell">
                <i data-feather="frown" class="icon"></i>
                {!! __('PAGE_NOT_FOUND') !!}
            </div>
        </div>
    </div>
</div>
@endsection
