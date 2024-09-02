<?php

namespace Tests\Feature\Seeder;

use Database\Seeders\CountersSeeder;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CounterSeederTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM products");
        DB::delete("delete FROM categories");
        DB::delete("DELETE FROM counters");
    }

    public function test_example(): void
    {
        self::seed(CountersSeeder::class);

        DB::table("counters")->where('id', '=', 'sample')->increment('counter', 1);

        $collection = DB::table("counters")->where('id', '=', 'sample')->get();
        self::assertNotNull($collection);
        self::assertCount(1, $collection);
        for ($i = 0; $i < count($collection); $i++) {
            Log::info(json_encode($collection[$i]));
        }
    }
}
