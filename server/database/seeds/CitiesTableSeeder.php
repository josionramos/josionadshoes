<?php

use App\Models\Address\City;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/cities.json');
        $data = json_decode($json);

        foreach ($data as $city) {
            City::create([
                'name' => $city->name,
                'state_id' => $city->state_id
            ]);
        }
    }
}
