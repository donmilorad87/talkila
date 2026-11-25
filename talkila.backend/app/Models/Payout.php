<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\Serializable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Payout
 *
 * @property-read \App\Models\FinanceCurrency             $finance_currencies
 * @property mixed                                        $payout_date
 * @property mixed                                        $transferred_date
 * @property-read Collection|\App\Models\BookingsPayout[] $payoutsBookingsPayouts
 * @property-read int|null                                $payouts_bookings_payouts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Payout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout newQuery()
 * @method static \Illuminate\Database\Query\Builder|Payout onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout query()
 * @method static \Illuminate\Database\Query\Builder|Payout withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Payout withoutTrashed()
 * @mixin \Eloquent
 */
class Payout extends Model
{
    use SoftDeletes, Auditable, Serializable;

    public $table = 'payouts';

    protected $dates = [
        'payout_date',
        'transferred_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'finance_currencies_id',
        'paid_with',
        'payout_date',
        'price',
        'invoice_number',
        'sales_tax',
        'reference',
        'transferred_date',
        'talkila_revenue',
        'talkila_sales_tax',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'sales_tax' => 'array',
    ];

    const PAID_WITH = [
        'pending' => 0,
        'sepa'    => 1,
        'paypal'  => 2,
    ];

    /* Relationship declarations
       ============================== */

    /**
     * Return Bookings attached to the Payout.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Return Bookings attached to the Payout.
     */
    public function talks()
    {
        return Talk::whereIn('id', $this->bookings->pluck('talk_id'))->get();
    }

    /**
     * Return User that owns the Payout.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payoutsBookingsPayouts()
    {
        return $this->hasMany(BookingsPayout::class, 'payouts_id', 'id');
    }

    public function finance_currencies()
    {
        return $this->belongsTo(FinanceCurrency::class, 'finance_currencies_id');
    }

    /* Methods
       ============================== */

    /**
     * Returns Payouts revenue.
     *
     * @return float
     */
    public function getRevenue(): float
    {
        return round($this->sum('price'), 2);
    }

    /**
     * Returns Payouts commission.
     *
     * @return float
     */
    public function getCommission(): float
    {
        return round($this->sum('talkila_revenue'), 2);
    }

    /**
     * Returns Payouts payout.
     *
     * @return float
     */
    public function getPayout(): float
    {
        return round($this->getRevenue() - $this->getCommission(), 2);
    }

    /**
     * Returns Payouts Bookings' transaction count.
     */
    public function getTransactionsCount()
    {
        return $this->all()->loadCount('bookings')->sum('bookings_count');
    }

    /**
     * Get Payout Bookings.
     *
     * @param  int|null  $limit   Limit the number of Bookings taken.
     * @param  int|null  $offset  Offset the Booking query.
     *
     * @return Collection
     */
    public function getBookings(?int $limit = null, ?int $offset = null): Collection
    {
        return $this->load('bookings')
            ->bookings()
            ->join('talks', 'talks.id', '=', 'bookings.talk_id')
            ->join('countries', 'countries.id', '=', 'bookings.vat_id')
            ->when($limit, function ($query) use ($limit) {
                $query->limit($limit);
            })
            ->when(is_null($limit), function ($query) use ($limit) {
                $query->limit(3);
            })
            ->when($offset && $limit != 0, function ($query) use ($offset) {
                $query->offset($offset);
            })
            ->get([
                'bookings.id',
                'talks.headline',
                "countries.{$this->setLanguage(request()->headers->get('accept-language'))} AS location",
                \DB::raw("CONCAT(TO_CHAR(bookings.start_date, 'DD.MM.YYYY'), ' ', SUBSTRING(bookings.start_time, 1, LENGTH(bookings.start_time)-3), ' - ', SUBSTRING(bookings.end_time, 1, LENGTH(bookings.end_time)-3)) AS date"),
                'bookings.price',
                \DB::raw('CASE WHEN bookings.parent_id IS NOT NULL THEN true ELSE false END AS extension'),
            ]);
    }

    /**
     * Get Payout Bookings for Admin Page.
     *
     * @return Collection
     */
    public function getBookingsForAdminPage(): Collection
    {
        return $this->load('bookings')
            ->bookings()
            ->join('countries', 'bookings.vat_id', '=', 'countries.id')
            ->join('talks', 'bookings.talk_id', '=', 'talks.id')
            ->select([
                'bookings.state',
                'bookings.id',
                'bookings.parent_id',
                'bookings.price as revenue',
                'bookings.vat',
                'talks.headline AS talk',
                'countries.english AS country',
                \DB::raw('ROUND(bookings.price-bookings.price*0.2, 2) AS payout'),
                \DB::raw('CONCAT(bookings.start_date, " ", SUBSTRING(bookings.start_time, 1, LENGTH(bookings.start_time)-3), " - ", SUBSTRING(bookings.end_time, 1, LENGTH(bookings.end_time)-3)) AS date'),
                \DB::raw("TO_CHAR(bookings.start_date, 'FMMonth') AS month"),
            ])
            ->selectRaw(
                "
                        CASE
                        WHEN bookings.state = '" . Booking::STATE['paid'] . "' THEN 'paid'
                        WHEN bookings.state = '" . Booking::STATE['completed'] . "' THEN 'completed'
                        WHEN bookings.state = '" . Booking::STATE['canceled'] . "' THEN 'canceled'
                        WHEN bookings.state = '" . Booking::STATE['canceled_without_refund'] . "' THEN 'canceled_without_refund'
                        WHEN bookings.state = '" . Booking::STATE['postponed'] . "' THEN 'postponed'
                        END as booking_state
                    "
            )
            ->where('bookings.state', '!=', Booking::STATE['waiting'])
            ->get();
    }

    public function getPayoutData()
    {
        $payouts = [];

        foreach ($this->sales_tax as $country_id => $tax) {
            foreach ($tax as $tax_value => $data) {
                $payouts[] = [
                    'id'                   => $this->id,
                    'country_of_residence' => Country::find($country_id)->english,
                    'vat_value'            => $tax_value,
                    'bookings_count'       => $data['bookings'],
                    'revenue'              => round($data['revenue'], 2),
                    'payout'               => round($data['payout'], 2),
                    'tax'                  => round($data['tax'], 2),
                    'net'                  => round($data['net'], 2),
                ];
            }
        }

        return $payouts;
    }

    /**
     * Return Payout Booking summary.
     */
    public function getBookingsSummary()
    {
        $payouts = [];

        foreach ($this->sales_tax as $country_id => $tax) {
            foreach ($tax as $tax_value => $data) {
                $payouts[] = [
                    'id'                   => $this->id,
                    'start_date'           => Carbon::parse($this->payout_date)->toDateString(),
                    'country_of_residence' => Country::find($country_id)->english,
                    'vat_value'            => $tax_value,
                    'bookings_count'       => $data['bookings'],
                    'revenue'              => round($data['revenue'], 2),
                    'payout'               => round($data['payout'], 2),
                    'tax'                  => round($data['tax'], 2),
                    'net'                  => round($data['net'], 2),
                ];
            }
        }

        return $payouts;
    }

    /**
     * Get Payout Bookings for Admin Page.
     *
     * @return mixed
     */
    public function getPayoutRevenue()
    {
        return collect($this->getPayoutData())->sum('revenue');
    }

    /**
     * Get Payout Bookings for Admin Page.
     *
     * @return float
     */
    public function getPayoutCommission(): float
    {
        return $this->getPayoutRevenue() * 0.2;
    }

    /**
     * Get Payout Bookings for Admin Page.
     *
     * @return float
     */
    public function getBookingsPayout(): float
    {
        return $this->getPayoutRevenue() - $this->getPayoutCommission();
    }

    /**
     * Get Payout Bookings for Admin Page.
     *
     * @return int
     */
    public function getBookingsCount(): int
    {
        return collect($this->getPayoutData())->sum('bookings_count');
    }

    /**
     * Returns all Suppliers.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSuppliers(): \Illuminate\Support\Collection
    {
        return $this
            ->join('users', 'users.id', '=', 'payouts.user_id')
            ->join('bookings as revenue', 'revenue.payout_id', '=', 'payouts.id')
            ->join('payouts_methods AS payout_method', 'users.id', '=', 'payout_method.user_id')
            ->select([
                'users.id',
                'users.username',
                'payouts.price AS revenue',
                'payouts.talkila_revenue AS commission',
                // 'ROUND(SUM(revenue.price-revenue.price*0.2), 2) AS payout',
                'payouts.payout_date as payout_date',
                'payouts.id as payout_id',
                \DB::raw("CASE WHEN payout_method.method=1 THEN 'IBAN' ELSE 'PayPal' END AS payout_method"),
            ])
            ->groupBy('revenue.teacher_user_id')
            ->get();
    }

    /**
     * Returns all Suppliers by Month.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSuppliersByMonth($month): \Illuminate\Support\Collection
    {
        return $this
            ->where('payout_date', $month)
            ->join('users', 'users.id', '=', 'payouts.user_id')
            ->join('bookings as revenue', 'revenue.payout_id', '=', 'payouts.id')
            ->join('payouts_methods AS payout_method', 'users.id', '=', 'payout_method.user_id')
            ->select([
                'users.id',
                'users.username',
                'payouts.price AS revenue',
                'payouts.talkila_revenue AS commission',
                // 'ROUND(SUM(revenue.price-revenue.price*0.2), 2) AS payout',
                'payouts.payout_date as payout_date',
                'payouts.id as payout_id',
                'payouts.paid_with',
                \DB::raw("CASE WHEN payout_method.method=1 THEN 'IBAN' ELSE 'PayPal' END AS payout_method"),
            ])
            ->groupBy('revenue.teacher_user_id')
            ->get();
    }

    /**
     * Returns all Payouts grouped by Month.
     */
    public function getPayoutsByMonth()
    {
        return $this->query()
            ->groupBy('payout_date')
            ->selectRaw('TO_CHAR(payout_date, \'YYYY-MM-DD\') AS date')
            ->selectRaw('invoice_number')
            ->selectRaw('reference')
            ->selectRaw('ROUND(SUM(price), 2) as revenue')
            ->selectRaw('ROUND(SUM(talkila_revenue), 2) as commission')
            ->withCount([
                'bookings as bookings' => function ($query) {
                    $query->join('payouts', 'bookings.payout_id', '=', 'payouts.id');
                    $query->count();
                },
            ])
            ->withCount([
                'bookings as paid_bookings' => function ($query) {
                    $query->join('payouts', 'bookings.payout_id', '=', 'payouts.id');
                    $query->whereNull('cancellation_reason_id');
                    $query->count();
                },
            ])
            ->withCount([
                'bookings as cancelled_bookings' => function ($query) {
                    $query->join('payouts', 'bookings.payout_id', '=', 'payouts.id');
                    $query->whereNotNull('cancellation_reason_id');
                    $query->count();
                },
            ])
            ->get();
    }

    /**
     * Returns a DB value depending on the Client Language.
     *
     * @param  string|null  $language  Client language.
     *
     * @return string
     */
    public function setLanguage(?string $language): string
    {
        switch ($language) {
            case 'en':
                return 'english';
            case 'hr':
                return 'croatian';
            case 'pl':
                return 'polish';
            default:
                return 'german';
        }
    }

    /* Accessors/Mutators
       ============================== */

    public function getPayoutDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setPayoutDateAttribute($value)
    {
        $this->attributes['payout_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getTransferredDateAttribute($value)
    {
        if (strtotime($value) < 0) {
            return null;
        }

        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setTransferredDateAttribute($value)
    {
        $this->attributes['transferred_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
}
