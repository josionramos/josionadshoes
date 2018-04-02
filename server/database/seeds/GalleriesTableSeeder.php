<?php

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GalleriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gallery::create([
            'name' => 'Produtos',
            'path' => 'products',
            'width' => 1920
        ]);

        Gallery::create([
            'name' => 'Slider',
            'path' => 'sliders',
            'width' => 1920
        ]);
    }
}
