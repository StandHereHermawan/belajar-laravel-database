<?php

namespace Tests\Feature\Transaction;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM categories");
    }

    public function testTransactionSuccess(): void
    {
        DB::transaction(function () {
            DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (?,?,?,?)", [
                "GADGET",
                'Gadget',
                "Gadget Category",
                '2023-03-12 11:57:56'
            ]);
            DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (?,?,?,?)", [
                "FOOD",
                'Food',
                "Food Category",
                '2023-03-12 11:57:56'
            ]);
            DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (:id,:name,:description,:created_at)", [
                "id" => "BARANG-ELEKTRONIK",
                "name" => 'Barang Elektronik',
                "description" => "Barang Elektronik Category",
                "created_at" => '2023-03-12 11:57:56'
            ]);
        });

        $results = DB::select("SELECT * FROM categories");

        self::assertNotNull($results);
        self::assertEquals(3, count($results));
    }

    public function testTransactionFailed(): void
    {
        try {
            //code...
            DB::transaction(function () {
                DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (?,?,?,?)", [
                    "GADGET",
                    'Gadget',
                    "Gadget Category",
                    '2023-03-12 11:57:56'
                ]);
                DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (?,?,?,?)", [
                    "FOOD",
                    'Food',
                    "Food Category",
                    '2023-03-12 11:57:56'
                ]);
                DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (:id,:name,:description,:created_at)", [
                    "id" => "BARANG-ELEKTRONIK",
                    "name" => 'Barang Elektronik',
                    "description" => "Barang Elektronik Category",
                    "created_at" => '2023-03-12 11:57:56'
                ]);
                DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (?,?,?,?)", [
                    "GADGET",
                    'Gadget',
                    "Gadget Category",
                    '2023-03-12 11:57:56'
                ]);
            });
        } catch (\Illuminate\Database\QueryException $th) {
            // expected error.
        }

        $results = DB::select("SELECT * FROM categories");

        self::assertEquals(0, count($results));
    }

    public function testManualTransactionSuccess(): void
    {
        try {
            DB::beginTransaction();
            DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (?,?,?,?)", [
                "FOOD",
                'Food',
                "Food Category",
                '2023-03-12 11:57:56'
            ]);
            DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (:id,:name,:description,:created_at)", [
                "id" => "BARANG-ELEKTRONIK",
                "name" => 'Barang Elektronik',
                "description" => "Barang Elektronik Category",
                "created_at" => '2023-03-12 11:57:56'
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        $results = DB::select("SELECT * FROM categories");

        self::assertNotNull($results);
        self::assertEquals(2, count($results));
    }

    public function testManualTransactionFailed(): void
    {
        try {
            DB::beginTransaction();
            DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (?,?,?,?)", [
                "FOOD",
                'Food',
                "Food Category",
                '2023-03-12 11:57:56'
            ]);
            DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (?,?,?,?)", [
                "FOOD",
                'Food',
                "Food Category",
                '2023-03-12 11:57:56'
            ]);
            DB::insert("INSERT INTO categories(id,name,description,created_at) VALUES (:id,:name,:description,:created_at)", [
                "id" => "BARANG-ELEKTRONIK",
                "name" => 'Barang Elektronik',
                "description" => "Barang Elektronik Category",
                "created_at" => '2023-03-12 11:57:56'
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        $results = DB::select("SELECT * FROM categories");

        self::assertEquals(0, count($results));
    }
}
