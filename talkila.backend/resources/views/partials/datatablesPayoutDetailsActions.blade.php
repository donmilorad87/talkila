<a style="color:#fff;" class="btn btn-xs btn-info rounded-0 mt-2 mr-2" href="{{ route('admin.payout-invoices.show', $row->payout_id) }}">
    Details
</a>
@if($row->paid_with === \App\Models\Payout::PAID_WITH['pending'] && $row->revenue > 0)
    <form style="display: inline" action="{{ route('admin.payout-invoices.payment', $row->payout_id) }}" method="POST">
        @csrf
        <input type="hidden" name="paid_with" value="{{ \App\Models\Payout::PAID_WITH['paypal'] }}">
        <input type="hidden" name="transferred_date" value="{{ now() }}">
        <button type="submit" style="color:#fff;" class="btn btn-xs btn-info rounded-0 mt-2 mr-2">
            Payout PP
        </button>
    </form>
    <form style="display: inline" action="{{ route('admin.payout-invoices.payment', $row->payout_id) }}" method="POST">
        @csrf
        <input type="hidden" name="paid_with" value="{{ \App\Models\Payout::PAID_WITH['sepa'] }}">
        <input type="hidden" name="transferred_date" value="{{ now() }}">
        <button type="submit" style="color:#fff;" class="btn btn-xs btn-info rounded-0 mt-2 mr-2">
            Payout Sepa
        </button>
    </form>
@endif
