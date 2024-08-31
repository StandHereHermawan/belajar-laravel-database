<?php

namespace Tests\Feature\QueryBuilder;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ChunkResultsTest extends TestCase
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

        $collection = DB::table("categories")->select(['id', 'name', 'description', 'created_at'])->get();

        self::assertCount(4, $collection);
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

    public function test_insert_table_products(): void
    {
        $this->test_where();

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
        for ($i = 3; $i < 9; $i++) {
            DB::table("products")->insert([
                'id' => $i,
                'name' => 'Baju Model ' . $i,
                'category_id' => 'FASHION',
                'price' => 75000 * $i,
                'description' => 'Baju Model' . $i
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

        for ($i = 9; $i < 100; $i++) {
            DB::table("products")->insert([
                'id' => $i,
                'name' => 'Celana Model ' . $i,
                'category_id' => 'FASHION',
                'price' => 35000 + (5000 * $i),
                'description' => 'Celana Model' . $i
            ]);
        }
    }

    public function test_chunk_results(): void
    {
        $this->test_insert_table_products();

        DB::table("products")
            ->orderBy('id')
            ->chunk(10, function ($products) {
                self::assertNotNull($products);
                Log::info("Start Chunk");
                $products->each(function ($product) {
                    Log::info(json_encode($product));
                });
                // foreach ($products as $product) {
                //     Log::info(json_encode($product));
                // }

                Log::info("End Chunk");
            });
    }
}
