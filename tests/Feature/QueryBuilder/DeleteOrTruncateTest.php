<?php

namespace Tests\Feature\QueryBuilder;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class DeleteOrTruncateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM products");
        DB::delete("DELETE FROM categories");
    }

    /**
     * A basic feature test example.
     */
    public function test_insert(): void
    {
        DB::table("categories")
            ->insert([
                'id' => 'SMARTPHONE',
                'name' => 'Smartphone',
                'created_at' => '2023-12-03 11:23:32'
            ]);
        DB::table("categories")
            ->insert([
                'id' => 'FOOD',
                'name' => 'Food',
                'created_at' => '2023-12-03 11:23:32'
            ]);
        DB::table("categories")
            ->insert([
                'id' => 'LAPTOP',
                'name' => 'Laptop',
                'created_at' => '2023-12-03 11:23:32'
            ]);
        DB::table("categories")
            ->insert([
                'id' => 'FASHION',
                'name' => 'Fashion',
                'created_at' => '2023-12-03 11:23:32'
            ]);

        self::assertTrue(true);
    }

    public function test_where(): void
    {
        $this->test_insert();

        $collection = DB::table("categories")->where(function (Builder $builder) {
            $builder->where('id', '=', 'SMARTPHONE');
            $builder->orWhere('id', '=', 'LAPTOP');
        })->get();
        // SELECT * FROM categories WHERE (id = smartphone OR id = laptop)

        self::assertNotNull($collection);
        self::assertCount(2, $collection);
        for ($i = 0; $i < count($collection); $i++) {
            Log::info(json_encode($collection[$i]));
        }
    }

    public function test_delete()
    {
        $this->test_where();

        DB::table("categories")->where('id', '=', 'SMARTPHONE')->delete();

        $collection = DB::table("categories")->where(function (Builder $builder) {
            $builder->where('id', '=', 'SMARTPHONE');
        })->get();

        self::assertNotNull($collection);
        self::assertCount(0, $collection);
    }
}
