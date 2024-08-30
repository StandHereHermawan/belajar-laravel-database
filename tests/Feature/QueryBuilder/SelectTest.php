<?php

namespace Tests\Feature\QueryBuilder;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SelectTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM categories");
    }

    public function test_insert(): void
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

    public function test_select(): void
    {
        $this->test_insert();

        $collection = DB::table("categories")->select(["id", "name"])->get();
        self::assertNotNull($collection);

        $collection->each(function ($record) {
            self::assertNotNull($record);
            Log::info(json_encode($record));
        });
    }
}
