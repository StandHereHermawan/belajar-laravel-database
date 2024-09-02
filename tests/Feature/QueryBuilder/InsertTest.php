<?php

namespace Tests\Feature\QueryBuilder;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class InsertTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM products");
        DB::delete("DELETE FROM categories");
    }

    public function test_example(): void
    {
        DB::table("categories")->insert([
            'id' => 'GADGET',
            'name' => 'Gadget'
        ]);
        DB::table("categories")->insert([
            'id' => 'FOOD',
            'name' => 'Food'
        ]);
        DB::table("categories")->insert([
            'id' => 'SPARE-PART',
            'name' => 'Sparepart'
        ]);

        $result = DB::select("SELECT COUNT(id) as total FROM categories");

        self::assertNotNull($result);
        self::assertEquals(3, $result[0]->total);
    }
}
