<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // RefreshDatabase drops every table: never let a test run against a real database.
        $database = (string) config('database.connections.'.config('database.default').'.database');
        if (! str_ends_with($database, '_test')) {
            throw new RuntimeException("Tests must use a *_test database, got \"{$database}\". Check phpunit.xml.");
        }
    }
}
