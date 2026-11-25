<?php

namespace App\Traits;

use DateTimeInterface;

trait Serializable
{
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  DateTimeInterface  $date
     *
     * @return string
     */
    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
