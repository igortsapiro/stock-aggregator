<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\MigrateFresh;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use MigrateFresh;
}
