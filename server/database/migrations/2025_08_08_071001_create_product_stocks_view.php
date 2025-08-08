<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW product_variation_stock_view AS 
            SELECT
                product_variations.product_id,
                product_variations.id AS product_variation_id,
                COALESCE(SUM(product_variation_stock.quantity) - COALESCE(SUM(product_variation_order.quantity), 0), 0) as stock,
                CASE WHEN COALESCE(SUM(product_variation_stock.quantity) - COALESCE(SUM(product_variation_order.quantity), 0), 0) > 0
                    THEN true
                    ELSE false
                END in_stock
            FROM
                product_variations
                LEFT JOIN (
                    SELECT
                        stocks.product_variation_id AS id,
                        SUM(stocks.quantity) AS quantity
                    FROM
                        stocks
                    GROUP BY
                        stocks.product_variation_id
                ) AS product_variation_stock ON product_variations.id = product_variation_stock.id
                LEFT JOIN (
                    SELECT 
                        product_variation_orders.product_variation_id as id,
                        SUM(product_variation_orders.quantity) as quantity
                    FROM 
                        product_variation_orders
                    GROUP BY 
                        product_variation_orders.product_variation_id
            ) AS product_variation_order ON product_variation_stock.id = product_variation_order.id
            GROUP BY product_variations.id;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS product_variation_stock_view');
    }
};
