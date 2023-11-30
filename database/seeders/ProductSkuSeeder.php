<?php

namespace Database\Seeders;

use App\Models\ProductSku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSkuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                "name" => "Bottle",
                "slug" => "bottle",
            ],
            [
                "name" => "Can",
                "slug" => "can",
            ],
            [
                "name" => "Carton",
                "slug" => "carton",
            ],
            [
                "name" => "Bale",
                "slug" => "bale",
            ]
        ])->each(function ($sku){
           ProductSku::query()->updateOrCreate($sku);
        });
    }
}
