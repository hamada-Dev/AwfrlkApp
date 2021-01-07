<?php

use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Area::create([
            'name'          => 'cairo',
            'trans_price'   => 25,
            'added_by'      => 1,
        ]);
    }
}
