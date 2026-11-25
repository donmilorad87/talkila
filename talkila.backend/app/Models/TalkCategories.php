<?php

namespace App\Models;

use App\Helpers\Filters;
use App\Traits\Auditable;
use App\Traits\RoutedByName;
use App\Traits\Serializable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TalkCategories extends Model
{
    use SoftDeletes, Auditable, Serializable, RoutedByName;

    public $table = 'talk_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'croatian',
        'german',
        'english',
        'french',
        'dutch',
        'czech',
        'romanian',
        'italian',
        'spanish',
        'polish',
        'bulgarian',
        'turkish',
        'danish',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Talk filters.
     */
    public $filters;

    /**
     * Create a new Model instance.
     */
    public function __construct(array $attributes = [])
    {
        $this->filters = new Filters();

        parent::__construct($attributes);
    }

    /* Relationship declarations
       ============================== */

    public function talks()
    {
        return $this->hasMany(Talk::class, 'talk_categories_id', 'id');
    }

    public function subcategories()
    {
        return $this->hasMany(TalkSubcategories::class, 'talk_categories_id');
    }

    /* Methods
       ============================== */

    /**
     * Return all Subcategories that have Active talks.
     *
     * @return mixed
     */
    public function getActiveSubcategoriesForTalks($talks)
    {
        $subcategories = $this->subcategories->loadCount([
            'talks as talks_count' => function ($query) {
                $query->where('teacher_user_id', '!=', auth()->id());
                $query->withEligibleSuppliers();
            },
        ])
            ->where('talks_count', '!=', 0);

        foreach ($subcategories as $key => $subcategory) {
            if (! in_array($subcategory->id, Arr::pluck($talks, 'talk_subcategories_id'))) {
                $subcategories->forget($key);
            }
        }

        return $subcategories;
    }

    /* Accessors/Mutators
       ============================== */

    /**
     * Get the Talk Category name depending on the User selected language.
     *
     * @return mixed
     */
    public function getNameAttribute()
    {
        switch (Str::upper(session('language'))) {
            case('DE'):
                return $this->german;
            case('HR'):
                return $this->croatian;
            case('PL'):
                return $this->polish;
            default:
                return $this->english;
        }
    }
}