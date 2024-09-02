<?php

namespace Tests\Feature\Seeder;

use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CategorySeederTest extends TestCase
{
    function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM products");
        DB::delete("DELETE FROM categories");
    }

    /**
     * A basic feature test example.
     */
    public function test_seeder_example(): void
    {
        $this->seed(CategorySeeder::class);

        $collection = DB::table("categories")->get();
        self::assertCount(5, $collection);
        foreach ($collection as $item) {
            self::assertNotNull($item);
            Log::info(json_encode($item));
        }
        DB::delete("DELETE FROM products");
        DB::delete("DELETE FROM categories");
    }
}
