<?php

use App\Models\Address\State;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/states.json');
        $data = json_decode($json);

        foreach ($data as $state) {
            State::create([
                'name' => $state->name,
                'uf' => $state->uf
            ]);
        }
    }
}
