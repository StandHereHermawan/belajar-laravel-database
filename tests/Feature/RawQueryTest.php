<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RawQueryTest extends TestCase
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
    public function test_crud_example(): void
    {
        DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (?,?,?,?)", [
            "GADGET",
            'Gadget',
            "Gadget Category",
            '2023-03-12 11:57:56'
        ]);

        $results = DB::select("SELECT * FROM categories WHERE id = ?", ["GADGET"]);

        self::assertEquals(1, count($results));
        self::assertEquals("GADGET", $results[0]->id);
        self::assertEquals("Gadget", $results[0]->name);
        self::assertEquals("Gadget Category", $results[0]->description);
        self::assertEquals("2023-03-12 11:57:56", $results[0]->created_at);
    }

    /**
     * A basic feature test example.
     */
    public function test_named_binding(): void
    {
        DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (:id,:name,:description,:created_at)", [
            "id" => "GADGET",
            "name" => 'Gadget',
            "description" => "Gadget Category",
            "created_at" => '2023-03-12 11:57:56'
        ]);

        $results = DB::select("SELECT * FROM categories WHERE id = :id", ["id" => "GADGET"]);

        self::assertEquals(1, count($results));
        self::assertEquals("GADGET", $results[0]->id);
        self::assertEquals("Gadget", $results[0]->name);
        self::assertEquals("Gadget Category", $results[0]->description);
        self::assertEquals("2023-03-12 11:57:56", $results[0]->created_at);
    }

    
}
