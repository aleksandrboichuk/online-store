<?php

use Illuminate\DatabASe\Migrations\Migration;
use Illuminate\DatabASe\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

clASs CreateElasticProductsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement(
            "CREATE VIEW elastic_products
                   AS
                   SELECT DISTINCT
                    p.id AS id, 
                    p.name AS name, 
                    p.seo_name AS seo_name, 
                    p.preview_img_url AS preview_img_url, 
                    p.description AS description, 
                    p.price AS price, 
                    p.discount AS discount, 
                    p.count AS count, 
                    p.in_stock AS in_stock, 
                    p.active AS active, 
                    p.created_at AS created_at, 
                    p.updated_at AS updated_at, 
                    p.category_group_id AS product_category_group, 
                    p.category_id AS product_category, 
                    p.category_sub_id AS product_category_sub, 
                    p.product_color_id AS product_color, 
                    p.product_season_id AS product_season, 
                    p.product_brand_id AS product_brand,
                    cg.name AS cg_name,
                    cg.seo_name AS cg_seo_name,
                    c.title AS c_title,
                    c.name AS c_name,
                    c.seo_name AS c_seo_name,
                    sc.title AS sc_title,
                    sc.name AS sc_name,
                    sc.seo_name AS sc_seo_name,
                    pc.id AS pc_id,
                    pc.name AS pc_name,
                    pc.seo_name AS pc_seo_name,
                    ps.id AS ps_id,
                    ps.name AS ps_name,
                    ps.seo_name AS ps_seo_name,
                    pb.id AS pb_id,
                    pb.name AS pb_name,
                    pb.seo_name AS pb_seo_name,
                    pm.id AS pm_id,
                    pm.name AS pm_name,
                    pm.seo_name AS pm_seo_name,
                    psize.id AS psize_id,
                    psize.name AS psize_name,
                    psize.seo_name AS psize_seo_name
                FROM
                    products p 
                    LEFT JOIN category_groups cg ON cg.id = p.category_group_id                
                    LEFT JOIN categories c ON c.id = p.category_id
                    LEFT JOIN sub_categories sc ON sc.id = p.category_sub_id
                    LEFT JOIN product_colors pc ON pc.id = p.product_color_id
                    LEFT JOIN product_seasons ps ON ps.id = p.product_season_id
                    LEFT JOIN product_brands pb ON pb.id = p.product_brand_id               
                    LEFT JOIN product_product_size ppsi ON p.id = ppsi.product_id
                    LEFT JOIN product_sizes psize ON psize.id = ppsi.product_size_id
                    LEFT JOIN product_product_material ppm ON p.id = ppm.product_id
                    LEFT JOIN product_materials pm ON pm.id = ppm.product_material_id where p.active != false
                    ORDER BY p.id desc"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::statement("DROP VIEW elastic_products");
    }
}
