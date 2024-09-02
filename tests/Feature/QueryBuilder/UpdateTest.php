<?php

namespace Tests\Feature\QueryBuilder;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM products");
        DB::delete("delete FROM categories");
        DB::delete("DELETE FROM counters");
    }

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

    public function test_update(): void
    {
        $this->test_where();

        DB::table("categories")->where('id', '=', 'SMARTPHONE')->update(['name' => 'Handphone']);

        $collection = DB::table("categories")->where('name', '=', 'Handphone')->get();
        self::assertNotNull($collection);
        self::assertCount(1, $collection);
        for ($i = 0; $i < count($collection); $i++) {
            Log::info(json_encode($collection[$i]));
        }
        self::assertNotSame("Smartphone", $collection[0]->name);
        self::assertSame("Handphone", $collection[0]->name);
    }

    public function test_upsert(): void
    {
        $this->test_where();

        DB::table("categories")->updateOrInsert(['id' => 'VOUCHER'], ['name' => 'Voucher', 'description' => 'Ticket and Voucher', 'created_at' => '2023-12-03 10:12:12']);

        $collection = DB::table("categories")->where('id', '=', 'VOUCHER')->get();
        self::assertNotNull($collection);
        self::assertCount(1, $collection);
        for ($i = 0; $i < count($collection); $i++) {
            Log::info(json_encode($collection[$i]));
        }
    }

    public function test_increment(): void
    {
        DB::table("counters")
            ->insert([
                'id' => 'sample',
                'counter' => 0
            ]);

        DB::table("counters")->where('id', '=', 'sample')->increment('counter', 1);

        $collection = DB::table("counters")->where('id', '=', 'sample')->get();
        self::assertNotNull($collection);
        self::assertCount(1, $collection);
        for ($i = 0; $i < count($collection); $i++) {
            Log::info(json_encode($collection[$i]));
        }
    }
}
