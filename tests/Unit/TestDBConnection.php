<?php

namespace Tests\Unit;

use DB;
use Tests\TestCase;

class TestDBConnection extends TestCase
{
    public function test_db_connection()
    {
        DB::connection()->getPDO();
        echo DB::connection()->getDatabaseName();
        $this->assertTrue(true);
    }
}
