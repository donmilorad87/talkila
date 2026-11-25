<?php

namespace App\Models;

use App\Helpers\Filters;
use App\ModelsApi\Talk;
use App\Traits\Auditable;
use App\Traits\Filterable;
use App\Traits\RoutedByName;
use App\Traits\Searchable;
use App\Traits\Serializable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TalkSubcategories extends Model
{
    use SoftDeletes, Auditable, Serializable, RoutedByName, Searchable, Filterable;

    public $table = 'talk_subcategories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'talk_categories_id',
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
        return $this->hasMany(Talk::class, 'talk_subcategories_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(TalkCategories::class, 'talk_categories_id', 'id');
    }


    /* Methods
       ============================== */

    /* Accessors/Mutators
       ============================== */

    /**
     * Get the Talk Subcategory name depending on the User selected language.
     *
     * @return mixed
     */
    public function getNameAttribute() {
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
