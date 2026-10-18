<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Blade views reference the Vite manifest; tests must not depend on a front-end build.
        $this->withoutVite();
    }
}
