<?php

namespace App\Traits;

trait RoutedByName
{
    /**
     * Change default Route Key to slug column instead of ID.
     */
    public function getRouteKeyName()
    {
        return 'english';
    }
}