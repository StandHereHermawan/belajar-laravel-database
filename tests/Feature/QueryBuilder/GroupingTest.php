<?php

namespace Tests\Feature\QueryBuilder;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class GroupingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM products");
        DB::delete("DELETE FROM categories");
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

        $collection = DB::table("categories")->select(['id', 'name', 'description', 'created_at'])->get();

        self::assertCount(4, $collection);
    }

    public function test_where(): void
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

    public function test_insert_table_products(): void
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

        $collection = DB::table("categories")->where(function (Builder $builder) {
            $builder->where('id', '=', 'SMARTPHONE');
            $builder->orWhere('id', '=', 'LAPTOP');
        })->get();
        // SELECT * FROM categories WHERE (id = smartphone OR id = laptop)

        self::assertNotNull($collection);
        self::assertCount(2, $collection);

        DB::table("products")->insert([
            'id' => '1',
            'name' => 'Iphone 14 Pro Max',
            'category_id' => 'SMARTPHONE',
            'price' => 13000000,
            'description' => 'Apple Iphone 14 Pro Max'
        ]);
        DB::table("products")->insert([
            'id' => '2',
            'name' => 'Samsung Galaxy S24 Ultra',
            'category_id' => 'SMARTPHONE',
            'price' => 15000000,
            'description' => 'Samsung Flagship'
        ]);

        $collection = DB::table("products")->select([
            'id',
            'name',
            'description',
            'created_at',
            'category_id',
            'price'
        ])->get();

        self::assertNotNull($collection);
    }

    public function test_insert_product_food(): void
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

        $collection = DB::table("categories")->where(function (Builder $builder) {
            $builder->where('id', '=', 'SMARTPHONE');
            $builder->orWhere('id', '=', 'LAPTOP');
        })->get();
        // SELECT * FROM categories WHERE (id = smartphone OR id = laptop)

        self::assertNotNull($collection);
        self::assertCount(2, $collection);

        DB::table("products")->insert([
            'id' => '1',
            'name' => 'Iphone 14 Pro Max',
            'category_id' => 'SMARTPHONE',
            'price' => 13000000,
            'description' => 'Apple Iphone 14 Pro Max'
        ]);
        DB::table("products")->insert([
            'id' => '2',
            'name' => 'Samsung Galaxy S24 Ultra',
            'category_id' => 'SMARTPHONE',
            'price' => 15000000,
            'description' => 'Samsung Flagship'
        ]);

        $collection = DB::table("products")->select([
            'id',
            'name',
            'description',
            'created_at',
            'category_id',
            'price'
        ])->get();

        self::assertNotNull($collection);

        for ($i = 3; $i <= 4; $i++) {
            DB::table("products")->insert([
                'id' => "$i",
                'name' => 'Makanan instant Model ' . $i,
                'category_id' => 'FOOD',
                'price' => 5000 + (500 * $i),
                'description' => 'Makanan instant Model ' . $i
            ]);
        }

        $collection = DB::table("products")->select([
            'id',
            'name',
            'description',
            'created_at',
            'category_id',
            'price'
        ])->get();

        self::assertNotNull($collection);
    }

    public function test_grouping(): void
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

        $collection = DB::table("categories")->where(function (Builder $builder) {
            $builder->where('id', '=', 'SMARTPHONE');
            $builder->orWhere('id', '=', 'LAPTOP');
        })->get();
        // SELECT * FROM categories WHERE (id = smartphone OR id = laptop)

        self::assertNotNull($collection);
        self::assertCount(2, $collection);

        DB::table("products")->insert([
            'id' => '1',
            'name' => 'Iphone 14 Pro Max',
            'category_id' => 'SMARTPHONE',
            'price' => 13000000,
            'description' => 'Apple Iphone 14 Pro Max'
        ]);
        DB::table("products")->insert([
            'id' => '2',
            'name' => 'Samsung Galaxy S24 Ultra',
            'category_id' => 'SMARTPHONE',
            'price' => 15000000,
            'description' => 'Samsung Flagship'
        ]);

        $collection = DB::table("products")->select([
            'id',
            'name',
            'description',
            'created_at',
            'category_id',
            'price'
        ])->get();

        self::assertNotNull($collection);

        for ($i = 3; $i <= 4; $i++) {
            DB::table("products")->insert([
                'id' => "$i",
                'name' => 'Makanan instant Model ' . $i,
                'category_id' => 'FOOD',
                'price' => 5000 + (500 * $i),
                'description' => 'Makanan instant Model ' . $i
            ]);
        }

        $collection = DB::table("products")->select([
            'id',
            'name',
            'description',
            'created_at',
            'category_id',
            'price'
        ])->get();

        self::assertNotNull($collection);

        $collection = DB::table("products")
            ->select('category_id', DB::raw('count(*) as total_product'))
            ->groupBy('category_id')
            ->orderBy('category_id', 'desc')
            ->get();

        self::assertNotNull($collection);
        self::assertEquals('SMARTPHONE', $collection[0]->category_id);
        self::assertEquals('FOOD', $collection[1]->category_id);
        self::assertEquals(2, $collection[0]->total_product);
        self::assertEquals(2, $collection[1]->total_product);

        for ($i = 0; $i < count($collection); $i++) {
            Log::info(json_encode($collection[$i]));
        }
    }

    public function test_having(): void
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

    $collection = DB::table("categories")->where(function (Builder $builder) {
        $builder->where('id', '=', 'SMARTPHONE');
        $builder->orWhere('id', '=', 'LAPTOP');
    })->get();
    // SELECT * FROM categories WHERE (id = smartphone OR id = laptop)

    self::assertNotNull($collection);
    self::assertCount(2, $collection);

    DB::table("products")->insert([
        'id' => '1',
        'name' => 'Iphone 14 Pro Max',
        'category_id' => 'SMARTPHONE',
        'price' => 13000000,
        'description' => 'Apple Iphone 14 Pro Max'
    ]);
    DB::table("products")->insert([
        'id' => '2',
        'name' => 'Samsung Galaxy S24 Ultra',
        'category_id' => 'SMARTPHONE',
        'price' => 15000000,
        'description' => 'Samsung Flagship'
    ]);

    $collection = DB::table("products")->select([
        'id',
        'name',
        'description',
        'created_at',
        'category_id',
        'price'
    ])->get();

    self::assertNotNull($collection);

    for ($i = 3; $i <= 4; $i++) {
        DB::table("products")->insert([
            'id' => "$i",
            'name' => 'Makanan instant Model ' . $i,
            'category_id' => 'FOOD',
            'price' => 5000 + (500 * $i),
            'description' => 'Makanan instant Model ' . $i
        ]);
    }

    $collection = DB::table("products")->select([
        'id',
        'name',
        'description',
        'created_at',
        'category_id',
        'price'
    ])->get();

    self::assertNotNull($collection);

        $collection = DB::table("products")
            ->select('category_id', DB::raw('count(*) as total_product'))
            ->groupBy('category_id')
            ->orderBy('category_id', 'desc')
            ->having(DB::raw('count(*)'), '>', 2)
            ->get();

        self::assertCount(0, $collection);
    }
}
