<?php

use App\Models\Product\VariantType;
use Illuminate\Database\Seeder;

class ProductVariantTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VariantType::create([
            'name' => 'Cor'
        ]);

        VariantType::create([
            'name' => 'Tamanho'
        ]);
    }
}
