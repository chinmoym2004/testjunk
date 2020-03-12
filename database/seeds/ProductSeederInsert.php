<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Http\Controllers\Elasticsearch;

class ProductSeederInsert extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 

        // for ($i=0; $i <1000 ; $i++) { 
        	


        // }
        $faker = Faker\Factory::create();

        $host = 'localhost:9200';

        for ($i=0; $i < 2000 ; $i++) { 
        	
        	$product = new Product;
			$product->title = $faker->realText(rand(20,40));
			$product->description = $faker->text;
			$product->category = $faker->realText(rand(20,40));
			$product->sku = $faker->realText($faker->numberBetween(10,20));
			$product->save();

			$params = [
			    'index' => 'product',
			    'id'    => $product->id,
			    'type'	=> '_doc',
			    'body'  => ['title'=>$product->title,'description'=>$product->description,"category"=>$product->category,"sku"=>$product->sku]
			];
			// create index 
	        $es = Elasticsearch::index($host,$params);
        }

        echo "2000 Recod inserted";
    }
}
