<?php

use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['خضروات' , 'فواكه' , 'صيدليه','اكلات',];
        // $categories = ['ddddddddddd' , 'ccccccc' , 'bbbbbbbbbb','aaaaaaaaaa',];

        foreach ($categories as $index=>$category){

            Category::create([
                'name' => $category,
                'added_by' => 1,
            ]);

        } // end of foreach

    }
}
