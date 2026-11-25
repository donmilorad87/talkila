<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VAT extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'static_vat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'english',
        'german',
        'croatian',
        'country_code',
        'value',
    ];

    /* Relationships
   ============================== */

    /* Accessors/Mutators
   ============================== */

    /* Methods
   ============================== */

    /**
     * Returns all VAT info.
     */
    public function getAll()
    {
        return $this->all('id', $this->getLanguage() . ' as country', 'country_code', 'value');
    }

    /**
     * Get Application Language.
     *
     * @return string
     */
    public function getLanguage() {
        switch (request()->header('Application-Language')) {
            case 'de':
                return 'german';
            case 'hr':
                return 'croatian';
            default;
                return 'english';
        }
    }

    /**
     * Get the Language name depending on the User selected language.
     *
     * @return mixed
     */
    public function getNameAttribute() {
        switch (Str::lower(session('language'))) {
            case('de'):
                return $this->german;
            case('hr'):
                return $this->croatian;
            default:
                return $this->english;
        }
    }
}
