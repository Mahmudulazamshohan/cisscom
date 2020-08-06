<?php

use App\Products;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'manufacturer'=>'BMW',
                'model'=>'Isetta',
                'year'=>'1955',
                'country'=>'Germany'
            ],[
                'manufacturer'=>'Kia',
                'model'=>'Picanto',
                'year'=>'2004',
                'country'=>'South Korea'
            ]
        ];
        foreach ($products as $product){
            Products::create($product);
        }
    }
}
