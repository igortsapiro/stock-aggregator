<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Support\Facades\Artisan;

trait MigrateFresh
{
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate:fresh --seed');
    }
}
